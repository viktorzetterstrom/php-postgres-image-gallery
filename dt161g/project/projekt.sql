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
  role        text NOT NULL CHECK (role <> ''),
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
  user_id     integer REFERENCES dt161g.project_user (id),
  role_id     integer REFERENCES dt161g.project_role (id),
  CONSTRAINT  project_unique_user_role UNIQUE(user_id, role_id)
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

