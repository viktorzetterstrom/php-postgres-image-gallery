-- ##############################################
-- KURS: DT161G
-- Projekt
-- Viktor Zetterström
-- vize1500@student.miun.se
-- ##############################################

-- Create table users
DROP TABLE IF EXISTS dt161g.project_user;

CREATE TABLE dt161g.project_user (
  id          SERIAL PRIMARY KEY,
  username    text NOT NULL CHECK (username <> ''),
  password    text NOT NULL CHECK (password  <> ''),
  CONSTRAINT  unique_user UNIQUE(username)
)
WITHOUT OIDS;

-- Create users
INSERT INTO dt161g.project_user (username, password) VALUES ('m','m');
INSERT INTO dt161g.project_user (username, password) VALUES ('a','a');

-- ##############################################

-- Create table role
DROP TABLE IF EXISTS dt161g.project_role;

CREATE TABLE dt161g.project_role (
  id          SERIAL PRIMARY KEY,
  role        text NOT NULL CHECK (role <> ''),
  CONSTRAINT  unique_role UNIQUE(role)
)
WITHOUT OIDS;

-- Create roles
INSERT INTO dt161g.role (role, roletext) VALUES ('user');
INSERT INTO dt161g.role (role, roletext) VALUES ('admin');

-- ##############################################

-- Create table user_role
DROP TABLE IF EXISTS dt161g.project_user_role;

CREATE TABLE dt161g.project_user_role (
  id          SERIAL PRIMARY KEY,
  user_id     integer REFERENCES dt161g.project_user (id),
  role_id     integer REFERENCES dt161g.project_role (id),
  CONSTRAINT  unique_user_role UNIQUE(user_id, role_id)
)
WITHOUT OIDS;

-- Connect users with roles
INSERT INTO dt161g.project_user_role (user_id, role_id) VALUES (1,1);
INSERT INTO dt161g.project_user_role (user_id, role_id) VALUES (2,1);
INSERT INTO dt161g.project_user_role (user_id, role_id) VALUES (2,2);


-- ##############################################

-- Create table pictures
-- DROP TABLE IF EXISTS project_pictures;

-- CREATE TABLE dt161g.project_pictures (
--   id          SERIAL PRIMARY KEY,
--   user        integer REFERENCES dt161g.project_user (id)
-- )
-- WITHOUT OIDS;

-- Insert pictures



-- Create table pictures_users
