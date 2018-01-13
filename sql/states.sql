--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.6
-- Dumped by pg_dump version 9.6.6

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET search_path = public, pg_catalog;

--
-- Data for Name: states; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO states (id, description, short, created_at, updated_at) VALUES (1, 'Alabama', 'AL', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (2, 'Alaska', 'AK', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (3, 'Arizona', 'AZ', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (4, 'Arkansas', 'AR', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (5, 'California', 'CA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (6, 'Colorado', 'CO', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (7, 'Connecticut', 'CT', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (8, 'Delaware', 'DE', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (9, 'Florida', 'FL', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (10, 'Georgia', 'GA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (11, 'Hawaii', 'HI', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (12, 'Idaho', 'ID', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (13, 'Illinois', 'IL', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (14, 'Indiana', 'IN', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (15, 'Iowa', 'IA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (16, 'Kansas', 'KS', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (17, 'Kentucky', 'KY', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (18, 'Louisiana', 'LA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (19, 'Maine', 'ME', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (20, 'Maryland', 'MD', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (21, 'Massachusetts', 'MA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (22, 'Michigan', 'MI', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (23, 'Minnesota', 'MN', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (24, 'Mississippi', 'MS', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (25, 'Missouri', 'MO', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (26, 'Montana', 'MT', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (27, 'Nebraska', 'NE', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (28, 'Nevada', 'NV', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (29, 'HAMPSHIRE', 'New', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (30, 'JERSEY', 'New', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (31, 'MEXICO', 'New', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (32, 'YORK', 'New', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (33, 'CAROLINA', 'North', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (34, 'DAKOTA', 'North', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (35, 'Ohio', 'OH', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (36, 'Oklahoma', 'OK', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (37, 'Oregon', 'OR', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (38, 'Pennsylvania', 'PA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (39, 'ISLAND', 'Rhode', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (40, 'CAROLINA', 'South', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (41, 'DAKOTA', 'South', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (42, 'Tennessee', 'TN', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (43, 'Texas', 'TX', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (44, 'Utah', 'UT', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (45, 'Vermont', 'VT', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (46, 'Virginia', 'VA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (47, 'Washington', 'WA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (48, 'VIRGINIA', 'West', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (49, 'Wisconsin', 'WI', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (50, 'Wyoming', 'WY', NULL, NULL);


--
-- Name: states_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('states_id_seq', 50, true);


--
-- PostgreSQL database dump complete
--

