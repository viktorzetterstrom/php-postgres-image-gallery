-- ##############################################
-- KURS: DT161G
-- Projekt
-- Viktor Zetterström
-- vize1500@student.miun.se
-- ##############################################

-- Create table users
DROP TABLE IF EXISTS dt161g.project_user CASCADE;

CREATE TABLE dt161g.project_user (
  id          SERIAL PRIMARY KEY,
  username    text NOT NULL CHECK (username <> ''),
  password    text NOT NULL CHECK (password  <> ''),
  CONSTRAINT  project_unique_user UNIQUE(username)
)
WITHOUT OIDS;

-- Create users
INSERT INTO dt161g.project_user (username, password) VALUES ('m', '$2y$10$D2pgcOU3MeYErEH.ob4b6.V.ImHipfqzRHlXMKSaXX0HPoF8LTbeW');
INSERT INTO dt161g.project_user (username, password) VALUES ('a', '$2y$10$y27OVVY.36wXF2cYX.fRP.5/J1B0zh6qrfFQaiVQPuQ41yW1ZuNyy');

-- ##############################################

-- Create table role
DROP TABLE IF EXISTS dt161g.project_role CASCADE;

CREATE TABLE dt161g.project_role (
  id          SERIAL PRIMARY KEY,
  role        TEXT NOT NULL CHECK (role <> ''),
  CONSTRAINT  project_unique_role UNIQUE(role)
)
WITHOUT OIDS;

-- Create roles
INSERT INTO dt161g.project_role (role) VALUES ('user');
INSERT INTO dt161g.project_role (role) VALUES ('admin');

-- ##############################################

-- Create table user_role
DROP TABLE IF EXISTS dt161g.project_user_role;

CREATE TABLE dt161g.project_user_role (
  id          SERIAL PRIMARY KEY,
  user_id     INTEGER REFERENCES dt161g.project_user (id) ON DELETE CASCADE,
  role_id     INTEGER REFERENCES dt161g.project_role (id) ON DELETE CASCADE,
  CONSTRAINT  project_unique_user_role UNIQUE(user_id, role_id)
)
WITHOUT OIDS;

-- Connect users with roles
INSERT INTO dt161g.project_user_role (user_id, role_id) VALUES (1,1);
INSERT INTO dt161g.project_user_role (user_id, role_id) VALUES (2,1);
INSERT INTO dt161g.project_user_role (user_id, role_id) VALUES (2,2);


-- ##############################################

-- Create table category
DROP TABLE IF EXISTS dt161g.project_category CASCADE;

CREATE TABLE dt161g.project_category (
  id          SERIAL PRIMARY KEY,
  user_id     INTEGER REFERENCES dt161g.project_user(id) ON DELETE CASCADE,
  name        TEXT NOT NULL
)
WITHOUT OIDS;


-- ##############################################

-- Create table images
DROP TABLE IF EXISTS dt161g.project_image;

CREATE TABLE dt161g.project_image (
  id          SERIAL PRIMARY KEY,
  checksum    INTEGER,
  imageData   BYTEA NOT NULL,
  category_id     INTEGER REFERENCES dt161g.project_category (id) ON DELETE CASCADE,
  user_id     INTEGER REFERENCES dt161g.project_user (id) ON DELETE CASCADE,
  CONSTRAINT  project_unique_image UNIQUE(checksum)
)
WITHOUT OIDS;
