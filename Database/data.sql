--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.10
-- Dumped by pg_dump version 9.6.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: _blood; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._blood (
    blood_id character varying(1) DEFAULT NULL::character varying,
    blood_name character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._blood OWNER TO rebasedata;

--
-- Name: _data; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._data (
    hid character varying(1) DEFAULT NULL::character varying,
    temp_body character varying(1) DEFAULT NULL::character varying,
    spo2 character varying(1) DEFAULT NULL::character varying,
    heart_rate character varying(1) DEFAULT NULL::character varying,
    "timestamp" character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._data OWNER TO rebasedata;

--
-- Name: _patient; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._patient (
    hid character varying(1) DEFAULT NULL::character varying,
    p_fname character varying(1) DEFAULT NULL::character varying,
    p_lname character varying(1) DEFAULT NULL::character varying,
    dob character varying(1) DEFAULT NULL::character varying,
    blood character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._patient OWNER TO rebasedata;

--
-- Name: _patient_mass; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._patient_mass (
    hid character varying(1) DEFAULT NULL::character varying,
    weight character varying(1) DEFAULT NULL::character varying,
    height character varying(1) DEFAULT NULL::character varying,
    "timestamp" character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public._patient_mass OWNER TO rebasedata;

--
-- Data for Name: _blood; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._blood (blood_id, blood_name) FROM stdin;
\.


--
-- Data for Name: _data; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._data (hid, temp_body, spo2, heart_rate, "timestamp") FROM stdin;
\.


--
-- Data for Name: _patient; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._patient (hid, p_fname, p_lname, dob, blood) FROM stdin;
\.


--
-- Data for Name: _patient_mass; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._patient_mass (hid, weight, height, "timestamp") FROM stdin;
\.


--
-- PostgreSQL database dump complete
--

