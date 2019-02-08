/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: main.js
 * Desc: main JavaScript file for Laboration 3
 *
 * Viktor Zetterström
 * vize1500
 * vize1500@student.miun.se
 ******************************************************************************/

var xhr;                // Variabel att lagra XMLHttpRequestobjektet

/*******************************************************************************
 * Util functions
 ******************************************************************************/
function byId(id) {
  return document.getElementById(id);
}
function byClass(className) {
  return document.getElementsByClassName(className);
}
/******************************************************************************/


/*******************************************************************************
 * Main function
 ******************************************************************************/
function main() {

  byId('loginButton').addEventListener('click', doLogin, false);
  byId('logoutButton').addEventListener('click', doLogout, false);

  // Stöd för IE7+, Firefox, Chrome, Opera, Safari
  try {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xhr = new XMLHttpRequest();
    }
    else {
      throw new Error('Cannot create XMLHttpRequest object');
    }

  } catch (e) {
    alert('XMLHttpRequest failed!' + e.message);
  }
}
window.addEventListener('load', main, false); // Connect the main function to window load event

/*******************************************************************************
 * Function doLogin
 ******************************************************************************/
function doLogin() {
  let userName = byId('uname').value;
  let password = byId('psw').value;

  if (userName !== '' && password !== '') {
    xhr.addEventListener('readystatechange', processLogin, false);
    xhr.open('POST', 'login.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('uname=' + userName + '&psw=' + password);
  }
}

/*******************************************************************************
 * Function doLogout
 ******************************************************************************/
function doLogout() {
  xhr.addEventListener('readystatechange', processLogout, false);
  xhr.open('GET', 'logout.php', true);
  xhr.send(null);
}

/*******************************************************************************
 * Function processLogin
 ******************************************************************************/
function processLogin() {
  if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    //First we must remove the registered event since we use the same xhr object for login and logout
    xhr.removeEventListener('readystatechange', processLogin, false);

    let response = JSON.parse(this.responseText);
    byId('message').innerHTML = response.responseText;
    if (response.success) {
      byId('logout').style.display = 'block';
      byId('login').style.display = 'none';
      setSidebarLinks(response.links);
    }
  }
}

/*******************************************************************************
 * Function processLogout
 ******************************************************************************/
function processLogout() {
  if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    //First we most remove the registered event since we use the same xhr object for login and logout
    xhr.removeEventListener('readystatechange', processLogout, false);
    var response = JSON.parse(this.responseText);
    if (byId('message')) {
      byId('message').innerHTML = response.responseText;
    }
    setSidebarLinks(response.links);
    byId('login').style.display = 'block';
    byId('logout').style.display = 'none';
  }
}

/*******************************************************************************
 * Function setSidebarLinks
 ******************************************************************************/
function setSidebarLinks(links) {
  let sidebarLinks = byClass('sidebar-links')[0];
  sidebarLinks.innerHTML = '';
  for (let linkName in links) {
    if (links.hasOwnProperty(linkName)) {
      sidebarLinks.innerHTML += '<li><a href="'+ links[linkName] + '">' + linkName + '</a>';
    }
  }
}