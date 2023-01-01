--
-- PostgreSQL database dump
--

-- Dumped from database version 13.6 (Ubuntu 13.6-0ubuntu0.21.10.1)
-- Dumped by pg_dump version 13.6 (Ubuntu 13.6-0ubuntu0.21.10.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: gender_enum; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.gender_enum AS ENUM (
    'Male',
    'Female'
);


ALTER TYPE public.gender_enum OWNER TO postgres;

--
-- Name: yes_no_enum; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.yes_no_enum AS ENUM (
    'Yes',
    'No'
);


ALTER TYPE public.yes_no_enum OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: aauth_groups; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.aauth_groups (
    id bigint NOT NULL,
    name text NOT NULL,
    description text,
    created_at integer,
    updated_at integer,
    created_by integer,
    updated_by integer
);


ALTER TABLE public.aauth_groups OWNER TO postgres;

--
-- Name: aauth_groups_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.aauth_groups ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.aauth_groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: aauth_perm_to_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.aauth_perm_to_group (
    id bigint NOT NULL,
    permission bigint NOT NULL,
    "group" bigint NOT NULL,
    created_by integer,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.aauth_perm_to_group OWNER TO postgres;

--
-- Name: aauth_perm_to_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.aauth_perm_to_group ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.aauth_perm_to_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: aauth_perm_to_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.aauth_perm_to_user (
    id bigint NOT NULL,
    permission bigint NOT NULL,
    "user" bigint NOT NULL,
    active integer DEFAULT 1,
    expiry_date timestamp without time zone,
    created_by integer NOT NULL,
    created_at integer NOT NULL,
    updated_by integer,
    updated_at integer
);


ALTER TABLE public.aauth_perm_to_user OWNER TO postgres;

--
-- Name: aauth_perm_to_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.aauth_perm_to_user ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.aauth_perm_to_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: aauth_perms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.aauth_perms (
    id bigint NOT NULL,
    name text NOT NULL,
    description text,
    "group" character varying
);


ALTER TABLE public.aauth_perms OWNER TO postgres;

--
-- Name: aauth_perms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.aauth_perms ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.aauth_perms_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: aauth_user_files; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.aauth_user_files (
    id bigint NOT NULL,
    "user" bigint NOT NULL,
    name character varying NOT NULL,
    file character varying NOT NULL,
    created_by bigint,
    created_at integer NOT NULL,
    updated_by bigint,
    updated_at integer
);


ALTER TABLE public.aauth_user_files OWNER TO postgres;

--
-- Name: aauth_user_files_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.aauth_user_files ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.aauth_user_files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: aauth_user_to_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.aauth_user_to_group (
    id bigint NOT NULL,
    "user" bigint NOT NULL,
    "group" bigint NOT NULL,
    active integer DEFAULT 1 NOT NULL,
    created_by integer NOT NULL,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.aauth_user_to_group OWNER TO postgres;

--
-- Name: aauth_user_to_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.aauth_user_to_group ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.aauth_user_to_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: aauth_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.aauth_users (
    id bigint NOT NULL,
    "group" bigint NOT NULL,
    first_name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    phone character varying(255),
    email text NOT NULL,
    active integer NOT NULL,
    auth_key character varying(32) NOT NULL,
    password_hash text NOT NULL,
    password_reset_token character varying(255) DEFAULT NULL::character varying,
    verification_token text,
    ip_address text,
    login_attempts integer DEFAULT 0,
    updated_by integer,
    created_by integer,
    created_at integer NOT NULL,
    updated_at integer NOT NULL,
    man_number character varying(15),
    expiry_date date,
    username character varying(45) NOT NULL,
    last_login timestamp without time zone,
    other_name character varying,
    title character varying NOT NULL,
    image character varying,
    CONSTRAINT aauth_users_created_at_check CHECK ((created_at > 0)),
    CONSTRAINT aauth_users_updated_at_check CHECK ((updated_at > 0))
);


ALTER TABLE public.aauth_users OWNER TO postgres;

--
-- Name: COLUMN aauth_users.username; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.aauth_users.username IS 'By default, man nos are the usernames';


--
-- Name: aauth_users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.aauth_users ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.aauth_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: accreditation_applications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.accreditation_applications (
    id bigint NOT NULL,
    organisation bigint NOT NULL,
    currency bigint NOT NULL,
    type character varying(45) NOT NULL,
    status character varying(20) NOT NULL,
    income double precision DEFAULT 0 NOT NULL,
    expenditure double precision DEFAULT 0 NOT NULL,
    letter character varying NOT NULL,
    registration_or_acknowledgement_certificate character varying NOT NULL,
    certified_articles_of_association character varying NOT NULL,
    bylaws character varying NOT NULL,
    statutes_or_constitution_detailing_the_mandate character varying NOT NULL,
    scope_and_governing_structure_or_organisational_profile character varying NOT NULL,
    annual_income_and_expenditure_statement character varying NOT NULL,
    names_of_all_donors_and_other_funding_sources_last_two_years character varying NOT NULL,
    evidence_of_competency_in_thematic_areas character varying NOT NULL,
    other_relevant_documents character varying,
    compliance_with_au_data_policy smallint DEFAULT 0 NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    number character varying(25)
);


ALTER TABLE public.accreditation_applications OWNER TO postgres;

--
-- Name: accreditation_applications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.accreditation_applications ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.accreditation_applications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: acreditation_application_approvals; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.acreditation_application_approvals (
    id bigint NOT NULL,
    application bigint NOT NULL,
    remarks_accreditation_officer character varying NOT NULL,
    status_accreditation_officer character varying(15) NOT NULL,
    approval_date_accreditation_officer timestamp without time zone,
    remarks_head_of_programs character varying NOT NULL,
    status_head_of_programs character varying(15) NOT NULL,
    approval_date_head_of_programs timestamp without time zone,
    acreditation_officer bigint,
    head_of_programs bigint,
    due_diligence_report character varying
);


ALTER TABLE public.acreditation_application_approvals OWNER TO postgres;

--
-- Name: acreditation_application_approvals_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.acreditation_application_approvals ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.acreditation_application_approvals_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: au_organs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.au_organs (
    id bigint NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.au_organs OWNER TO postgres;

--
-- Name: au_organs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.au_organs ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.au_organs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: audit_logs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.audit_logs (
    id bigint NOT NULL,
    "user" bigint NOT NULL,
    action text NOT NULL,
    extra_data text,
    date integer NOT NULL,
    ip_address character varying(25) NOT NULL,
    user_agent character varying NOT NULL
);


ALTER TABLE public.audit_logs OWNER TO postgres;

--
-- Name: audit_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.audit_logs ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.audit_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.categories ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: countries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.countries (
    id bigint NOT NULL,
    region bigint NOT NULL,
    name character varying NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    created_by bigint NOT NULL,
    updated_by bigint
);


ALTER TABLE public.countries OWNER TO postgres;

--
-- Name: countries_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.countries ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.countries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: currencies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.currencies (
    id bigint NOT NULL,
    name character varying NOT NULL,
    iso_code character varying(15) NOT NULL,
    created_by bigint NOT NULL,
    created_at integer NOT NULL,
    updated_by bigint,
    updated_at integer
);


ALTER TABLE public.currencies OWNER TO postgres;

--
-- Name: currencies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.currencies ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.currencies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: observer_status_applications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.observer_status_applications (
    id bigint NOT NULL,
    organisation bigint NOT NULL,
    au_organ bigint NOT NULL,
    status character varying NOT NULL,
    remarks character varying NOT NULL,
    approved_by character varying,
    date_approved timestamp without time zone,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.observer_status_applications OWNER TO postgres;

--
-- Name: observer_status_applications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.observer_status_applications ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.observer_status_applications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: official_languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.official_languages (
    id bigint NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.official_languages OWNER TO postgres;

--
-- Name: official_languages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.official_languages ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.official_languages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: organisation_area_of_expertise; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.organisation_area_of_expertise (
    id bigint NOT NULL,
    organisation bigint NOT NULL,
    sub_category bigint NOT NULL,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.organisation_area_of_expertise OWNER TO postgres;

--
-- Name: organisation_area_of_expertise_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.organisation_area_of_expertise ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.organisation_area_of_expertise_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: organisation_contact_persons; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.organisation_contact_persons (
    id bigint NOT NULL,
    organisation bigint NOT NULL,
    country bigint NOT NULL,
    title character varying(15) NOT NULL,
    formal_title character varying NOT NULL,
    first_name character varying NOT NULL,
    last_name character varying NOT NULL,
    other_names character varying,
    department character varying NOT NULL,
    telephone character varying NOT NULL,
    mobile character varying NOT NULL,
    fax character varying,
    whatsapp_number character varying,
    email character varying,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.organisation_contact_persons OWNER TO postgres;

--
-- Name: organisation_contact_persons_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.organisation_contact_persons ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.organisation_contact_persons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: organisation_registration_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.organisation_registration_details (
    id bigint NOT NULL,
    organisation bigint NOT NULL,
    country bigint NOT NULL,
    number character varying(45) NOT NULL,
    registration_date date NOT NULL,
    registration_expiry_date date NOT NULL,
    years_of_experience integer DEFAULT 0 NOT NULL,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.organisation_registration_details OWNER TO postgres;

--
-- Name: organisation_registration_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.organisation_registration_details ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.organisation_registration_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: organisation_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.organisation_types (
    id bigint NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.organisation_types OWNER TO postgres;

--
-- Name: organisation_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.organisation_types ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.organisation_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: organisations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.organisations (
    id bigint NOT NULL,
    country bigint NOT NULL,
    official_language bigint NOT NULL,
    type bigint NOT NULL,
    name character varying NOT NULL,
    acronym character varying(45),
    postal_address character varying NOT NULL,
    postal_code character varying(20) NOT NULL,
    town character varying NOT NULL,
    email character varying NOT NULL,
    auth_key character varying(45) NOT NULL,
    password_hash character varying(255) NOT NULL,
    password_reset_token character varying(255),
    verification_token character varying,
    login_attempts integer,
    last_login timestamp without time zone,
    created_at integer NOT NULL,
    updated_at integer,
    scope_of_operation character varying NOT NULL,
    website character varying NOT NULL,
    mobile character varying(25) NOT NULL,
    active smallint DEFAULT 0,
    username character varying NOT NULL,
    logo character varying
);


ALTER TABLE public.organisations OWNER TO postgres;

--
-- Name: organisations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.organisations ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.organisations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: regions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.regions (
    id bigint NOT NULL,
    name character varying NOT NULL,
    code character varying(45),
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.regions OWNER TO postgres;

--
-- Name: regions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.regions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.regions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: sub_categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sub_categories (
    id bigint NOT NULL,
    category bigint NOT NULL,
    name character varying NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.sub_categories OWNER TO postgres;

--
-- Name: sub_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.sub_categories ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.sub_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: aauth_groups aauth_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_groups
    ADD CONSTRAINT aauth_groups_pkey PRIMARY KEY (id);


--
-- Name: aauth_perm_to_group aauth_perm_to_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_pkey PRIMARY KEY (id);


--
-- Name: aauth_perm_to_user aauth_perm_to_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_pkey PRIMARY KEY (id);


--
-- Name: aauth_perms aauth_perms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perms
    ADD CONSTRAINT aauth_perms_pkey PRIMARY KEY (id);


--
-- Name: aauth_user_files aauth_user_files_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_files
    ADD CONSTRAINT aauth_user_files_pkey PRIMARY KEY (id);


--
-- Name: aauth_user_to_group aauth_user_to_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_pkey PRIMARY KEY (id);


--
-- Name: aauth_users aauth_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT aauth_users_pkey PRIMARY KEY (id);


--
-- Name: accreditation_applications accreditation_applications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accreditation_applications
    ADD CONSTRAINT accreditation_applications_pkey PRIMARY KEY (id);


--
-- Name: acreditation_application_approvals acreditation_application_approvals_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.acreditation_application_approvals
    ADD CONSTRAINT acreditation_application_approvals_pkey PRIMARY KEY (id);


--
-- Name: au_organs au_argan_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.au_organs
    ADD CONSTRAINT au_argan_name_unique UNIQUE (name);


--
-- Name: au_organs au_organs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.au_organs
    ADD CONSTRAINT au_organs_pkey PRIMARY KEY (id);


--
-- Name: audit_logs audit_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audit_logs
    ADD CONSTRAINT audit_logs_pkey PRIMARY KEY (id);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: categories category_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT category_name_unique UNIQUE (name);


--
-- Name: countries countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (id);


--
-- Name: currencies currencies_isocode_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.currencies
    ADD CONSTRAINT currencies_isocode_unique UNIQUE (iso_code);


--
-- Name: currencies currencies_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.currencies
    ADD CONSTRAINT currencies_name_unique UNIQUE (name);


--
-- Name: currencies currencies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.currencies
    ADD CONSTRAINT currencies_pkey PRIMARY KEY (id);


--
-- Name: aauth_users email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT email_unique UNIQUE (email) INCLUDE (email);


--
-- Name: aauth_users man_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT man_number_unique UNIQUE (man_number);


--
-- Name: observer_status_applications observer_status_applications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.observer_status_applications
    ADD CONSTRAINT observer_status_applications_pkey PRIMARY KEY (id);


--
-- Name: official_languages official_lang_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.official_languages
    ADD CONSTRAINT official_lang_name_unique UNIQUE (name);


--
-- Name: official_languages official_languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.official_languages
    ADD CONSTRAINT official_languages_pkey PRIMARY KEY (id);


--
-- Name: organisation_contact_persons org_contact_person_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_contact_persons
    ADD CONSTRAINT org_contact_person_email_unique UNIQUE (email);


--
-- Name: organisation_contact_persons org_contact_person_fax_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_contact_persons
    ADD CONSTRAINT org_contact_person_fax_unique UNIQUE (fax);


--
-- Name: organisation_contact_persons org_contact_person_mobile_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_contact_persons
    ADD CONSTRAINT org_contact_person_mobile_unique UNIQUE (mobile);


--
-- Name: organisation_contact_persons org_contact_person_telephone_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_contact_persons
    ADD CONSTRAINT org_contact_person_telephone_unique UNIQUE (telephone);


--
-- Name: organisation_contact_persons org_contact_person_whatsapp_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_contact_persons
    ADD CONSTRAINT org_contact_person_whatsapp_unique UNIQUE (whatsapp_number);


--
-- Name: organisation_registration_details org_registration_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_registration_details
    ADD CONSTRAINT org_registration_number_unique UNIQUE (number);


--
-- Name: organisation_types org_type_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_types
    ADD CONSTRAINT org_type_name_unique UNIQUE (name);


--
-- Name: organisation_area_of_expertise organisation_area_of_expertise_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_area_of_expertise
    ADD CONSTRAINT organisation_area_of_expertise_pkey PRIMARY KEY (id);


--
-- Name: organisation_contact_persons organisation_contact_persons_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_contact_persons
    ADD CONSTRAINT organisation_contact_persons_pkey PRIMARY KEY (id);


--
-- Name: organisations organisation_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisations
    ADD CONSTRAINT organisation_email_unique UNIQUE (email);


--
-- Name: organisations organisation_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisations
    ADD CONSTRAINT organisation_name_unique UNIQUE (name);


--
-- Name: organisation_registration_details organisation_registration_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_registration_details
    ADD CONSTRAINT organisation_registration_details_pkey PRIMARY KEY (id);


--
-- Name: organisation_types organisation_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_types
    ADD CONSTRAINT organisation_types_pkey PRIMARY KEY (id);


--
-- Name: organisations organisations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisations
    ADD CONSTRAINT organisations_pkey PRIMARY KEY (id);


--
-- Name: regions regions_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.regions
    ADD CONSTRAINT regions_name_unique UNIQUE (name);


--
-- Name: regions regions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.regions
    ADD CONSTRAINT regions_pkey PRIMARY KEY (id);


--
-- Name: sub_categories sub_cat_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_categories
    ADD CONSTRAINT sub_cat_name_unique UNIQUE (name);


--
-- Name: sub_categories sub_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_categories
    ADD CONSTRAINT sub_categories_pkey PRIMARY KEY (id);


--
-- Name: aauth_perm_to_group aauth_perm_to_group_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: aauth_perm_to_group aauth_perm_to_group_groupfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_groupfk FOREIGN KEY ("group") REFERENCES public.aauth_groups(id);


--
-- Name: aauth_perm_to_group aauth_perm_to_group_permfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_permfk FOREIGN KEY (permission) REFERENCES public.aauth_perms(id);


--
-- Name: aauth_perm_to_group aauth_perm_to_group_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: aauth_perm_to_user aauth_perm_to_user_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: aauth_perm_to_user aauth_perm_to_user_permissionfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_permissionfk FOREIGN KEY (permission) REFERENCES public.aauth_perms(id);


--
-- Name: aauth_perm_to_user aauth_perm_to_user_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: aauth_perm_to_user aauth_perm_to_user_userfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_userfk FOREIGN KEY ("user") REFERENCES public.aauth_users(id);


--
-- Name: regions aauth_user_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.regions
    ADD CONSTRAINT aauth_user_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: aauth_user_files aauth_user_files_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_files
    ADD CONSTRAINT aauth_user_files_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: aauth_user_files aauth_user_files_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_files
    ADD CONSTRAINT aauth_user_files_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: aauth_user_files aauth_user_files_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_files
    ADD CONSTRAINT aauth_user_files_user_fk FOREIGN KEY ("user") REFERENCES public.aauth_users(id);


--
-- Name: aauth_user_to_group aauth_user_to_group_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: aauth_user_to_group aauth_user_to_group_groupfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_groupfk FOREIGN KEY ("group") REFERENCES public.aauth_groups(id) NOT VALID;


--
-- Name: aauth_user_to_group aauth_user_to_group_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: aauth_user_to_group aauth_user_to_group_userfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_userfk FOREIGN KEY ("user") REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: regions aauth_user_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.regions
    ADD CONSTRAINT aauth_user_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: aauth_users aauth_users_group_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT aauth_users_group_fk FOREIGN KEY ("group") REFERENCES public.aauth_groups(id);


--
-- Name: acreditation_application_approvals application_approvals_ao_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.acreditation_application_approvals
    ADD CONSTRAINT application_approvals_ao_fk FOREIGN KEY (acreditation_officer) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: acreditation_application_approvals application_approvals_application_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.acreditation_application_approvals
    ADD CONSTRAINT application_approvals_application_fk FOREIGN KEY (application) REFERENCES public.accreditation_applications(id);


--
-- Name: acreditation_application_approvals application_approvals_hop_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.acreditation_application_approvals
    ADD CONSTRAINT application_approvals_hop_fk FOREIGN KEY (head_of_programs) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: accreditation_applications applications_currency_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accreditation_applications
    ADD CONSTRAINT applications_currency_fk FOREIGN KEY (currency) REFERENCES public.currencies(id);


--
-- Name: accreditation_applications applications_organisation_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.accreditation_applications
    ADD CONSTRAINT applications_organisation_fk FOREIGN KEY (organisation) REFERENCES public.organisations(id);


--
-- Name: au_organs au_organs_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.au_organs
    ADD CONSTRAINT au_organs_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: au_organs au_organs_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.au_organs
    ADD CONSTRAINT au_organs_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: categories categories_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: categories categories_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: countries countries_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: countries countries_region_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_region_fk FOREIGN KEY (region) REFERENCES public.regions(id);


--
-- Name: countries countries_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: currencies currencies_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.currencies
    ADD CONSTRAINT currencies_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: currencies currencies_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.currencies
    ADD CONSTRAINT currencies_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: aauth_groups groups_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_groups
    ADD CONSTRAINT groups_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: aauth_groups groups_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_groups
    ADD CONSTRAINT groups_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: observer_status_applications observer_status_auorgan_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.observer_status_applications
    ADD CONSTRAINT observer_status_auorgan_fk FOREIGN KEY (au_organ) REFERENCES public.au_organs(id);


--
-- Name: observer_status_applications observer_status_org_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.observer_status_applications
    ADD CONSTRAINT observer_status_org_fk FOREIGN KEY (organisation) REFERENCES public.organisations(id);


--
-- Name: official_languages official_lang_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.official_languages
    ADD CONSTRAINT official_lang_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: official_languages official_lang_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.official_languages
    ADD CONSTRAINT official_lang_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: organisation_area_of_expertise org_aoexpertise_organisation_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_area_of_expertise
    ADD CONSTRAINT org_aoexpertise_organisation_fk FOREIGN KEY (organisation) REFERENCES public.organisations(id) NOT VALID;


--
-- Name: organisation_area_of_expertise org_aoexpertise_subcategory_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_area_of_expertise
    ADD CONSTRAINT org_aoexpertise_subcategory_fk FOREIGN KEY (sub_category) REFERENCES public.sub_categories(id) NOT VALID;


--
-- Name: organisation_contact_persons org_contactperson_country_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_contact_persons
    ADD CONSTRAINT org_contactperson_country_fk FOREIGN KEY (country) REFERENCES public.countries(id);


--
-- Name: organisation_contact_persons org_contactperson_organisation_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_contact_persons
    ADD CONSTRAINT org_contactperson_organisation_fk FOREIGN KEY (organisation) REFERENCES public.organisations(id);


--
-- Name: organisation_registration_details org_reg_conutry_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_registration_details
    ADD CONSTRAINT org_reg_conutry_fk FOREIGN KEY (country) REFERENCES public.countries(id);


--
-- Name: organisation_registration_details org_reg_organisation_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_registration_details
    ADD CONSTRAINT org_reg_organisation_fk FOREIGN KEY (organisation) REFERENCES public.organisations(id);


--
-- Name: organisation_types org_types_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_types
    ADD CONSTRAINT org_types_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: organisation_types org_types_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisation_types
    ADD CONSTRAINT org_types_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: organisations organisations_country_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisations
    ADD CONSTRAINT organisations_country_fk FOREIGN KEY (country) REFERENCES public.countries(id);


--
-- Name: organisations organisations_official_lang_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisations
    ADD CONSTRAINT organisations_official_lang_fk FOREIGN KEY (official_language) REFERENCES public.official_languages(id);


--
-- Name: organisations organisations_type_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.organisations
    ADD CONSTRAINT organisations_type_fk FOREIGN KEY (type) REFERENCES public.organisation_types(id);


--
-- Name: sub_categories sub_categories_category_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_categories
    ADD CONSTRAINT sub_categories_category_fk FOREIGN KEY (category) REFERENCES public.categories(id);


--
-- Name: sub_categories sub_categories_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_categories
    ADD CONSTRAINT sub_categories_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: sub_categories sub_categories_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_categories
    ADD CONSTRAINT sub_categories_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- PostgreSQL database dump complete
--

