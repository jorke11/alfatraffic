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

INSERT INTO states (id, description, short, created_at, updated_at) VALUES (2, 'Alabama', 'AL', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (3, 'Alaska', 'AK', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (4, 'Arizona', 'AZ', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (5, 'Arkansas', 'AR', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (6, 'California', 'CA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (7, 'Colorado', 'CO', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (8, 'Connecticut', 'CT', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (9, 'Delaware', 'DE', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (10, 'Florida', 'FL', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (11, 'Georgia', 'GA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (12, 'Hawaii', 'HI', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (13, 'Idaho', 'ID', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (14, 'Illinois', 'IL', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (15, 'Indiana', 'IN', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (16, 'Iowa', 'IA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (17, 'Kansas', 'KS', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (18, 'Kentucky', 'KY', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (19, 'Louisiana', 'LA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (20, 'Maine', 'ME', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (21, 'Maryland', 'MD', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (22, 'Massachusetts', 'MA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (23, 'Michigan', 'MI', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (24, 'Minnesota', 'MN', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (25, 'Mississippi', 'MS', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (26, 'Missouri', 'MO', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (27, 'Montana', 'MT', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (28, 'Nebraska', 'NE', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (29, 'Nevada', 'NV', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (30, 'New Hampshire', 'NH', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (31, 'New Jersey', 'NJ', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (32, 'New Mexico', 'NM', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (33, 'New York', 'NY', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (34, 'North Carolina', 'NC', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (35, 'North Dakota', 'ND', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (36, 'Ohio', 'OH', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (37, 'Oklahoma', 'OK', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (38, 'Oregon', 'OR', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (39, 'Pennsylvania', 'PA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (40, 'Rhode Island', 'RI', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (41, 'South Carolina', 'SC', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (42, 'South Dakota', 'SD', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (43, 'Tennessee', 'TN', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (44, 'Texas', 'TX', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (45, 'Utah', 'UT', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (46, 'Vermont', 'VT', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (47, 'Virginia', 'VA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (48, 'Washington', 'WA', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (49, 'West Virginia', 'WV', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (50, 'Wisconsin', 'WI', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (51, 'Wyoming', 'WY', NULL, NULL);
INSERT INTO states (id, description, short, created_at, updated_at) VALUES (52, 'Other', 'OT', NULL, NULL);


--
-- Name: states_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('states_id_seq', 52, true);


--
-- PostgreSQL database dump complete
--

