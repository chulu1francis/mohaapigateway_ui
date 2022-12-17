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
    man_number character varying(15) NOT NULL,
    expiry_date date,
    department bigint NOT NULL,
    username character varying(45) NOT NULL,
    last_login timestamp without time zone,
    lms_account_created public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    other_name character varying,
    title character varying NOT NULL,
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
-- Name: academic_intakes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.academic_intakes (
    id bigint NOT NULL,
    study_structure bigint NOT NULL,
    year integer NOT NULL,
    code character varying(45) NOT NULL,
    description character varying(50) NOT NULL,
    first_session_start_date integer NOT NULL,
    first_session_end_date integer NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.academic_intakes OWNER TO postgres;

--
-- Name: COLUMN academic_intakes.code; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.academic_intakes.code IS 'Will be auto generated from year appended with the string session';


--
-- Name: academic_intakes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.academic_intakes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.academic_intakes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: academic_sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.academic_sessions (
    id bigint NOT NULL,
    intake bigint NOT NULL,
    code character varying(20) NOT NULL,
    name character varying NOT NULL,
    start_date integer,
    end_date integer,
    last_year smallint DEFAULT 0,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer,
    academic_year integer NOT NULL
);


ALTER TABLE public.academic_sessions OWNER TO postgres;

--
-- Name: admission_eligibility; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admission_eligibility (
    id bigint NOT NULL,
    program bigint NOT NULL,
    intake bigint NOT NULL,
    required_subjects integer DEFAULT 1 NOT NULL,
    worst_grade integer DEFAULT 9,
    created_by bigint NOT NULL,
    created_at integer NOT NULL,
    updated_by bigint,
    updated_at integer
);


ALTER TABLE public.admission_eligibility OWNER TO postgres;

--
-- Name: COLUMN admission_eligibility.required_subjects; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.admission_eligibility.required_subjects IS '4,5 or 6 subjects';


--
-- Name: admission_criteria_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.admission_eligibility ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.admission_criteria_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: admission_eligibility_required_subjects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admission_eligibility_required_subjects (
    id bigint NOT NULL,
    program bigint NOT NULL,
    subject bigint NOT NULL,
    intake bigint NOT NULL,
    created_by bigint NOT NULL,
    created_at integer NOT NULL,
    updated_by bigint,
    worst_grade bigint DEFAULT 9 NOT NULL,
    updated_at integer
);


ALTER TABLE public.admission_eligibility_required_subjects OWNER TO postgres;

--
-- Name: admission_eligibility_required_subjects_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.admission_eligibility_required_subjects ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.admission_eligibility_required_subjects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: applicant_files; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.applicant_files (
    id bigint NOT NULL,
    applicant bigint NOT NULL,
    name character varying NOT NULL,
    file character varying NOT NULL,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.applicant_files OWNER TO postgres;

--
-- Name: applicant_files_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.applicant_files ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.applicant_files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: applicant_guardian; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.applicant_guardian (
    id bigint NOT NULL,
    applicant bigint NOT NULL,
    first_name character varying NOT NULL,
    surname character varying NOT NULL,
    relation character varying NOT NULL,
    mobile character varying(16),
    email character varying,
    district bigint,
    residential_address text,
    alternative_phone character varying(20),
    created_at integer,
    updated_at integer
);


ALTER TABLE public.applicant_guardian OWNER TO postgres;

--
-- Name: applicant_guardian_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.applicant_guardian ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.applicant_guardian_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: applicant_location; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.applicant_location (
    id bigint NOT NULL,
    applicant bigint NOT NULL,
    district bigint NOT NULL,
    residential_address text,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.applicant_location OWNER TO postgres;

--
-- Name: applicant_location_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.applicant_location ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.applicant_location_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: applicant_previous_institution; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.applicant_previous_institution (
    id bigint NOT NULL,
    applicant bigint NOT NULL,
    institution character varying NOT NULL,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.applicant_previous_institution OWNER TO postgres;

--
-- Name: applicant_programs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.applicant_programs (
    id bigint NOT NULL,
    applicant bigint NOT NULL,
    program bigint NOT NULL,
    choice integer NOT NULL,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.applicant_programs OWNER TO postgres;

--
-- Name: applicant_programs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.applicant_programs ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.applicant_programs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: applicant_references; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.applicant_references (
    id bigint NOT NULL,
    applicant bigint NOT NULL,
    type character varying NOT NULL,
    name character varying NOT NULL,
    "position" character varying NOT NULL,
    email character varying NOT NULL,
    phone character varying(16) NOT NULL,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.applicant_references OWNER TO postgres;

--
-- Name: COLUMN applicant_references.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.applicant_references.type IS 'Professional or Academic';


--
-- Name: applicant_references_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.applicant_references ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.applicant_references_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: applicant_subjects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.applicant_subjects (
    id bigint NOT NULL,
    applicant bigint NOT NULL,
    subject bigint NOT NULL,
    grade integer NOT NULL,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.applicant_subjects OWNER TO postgres;

--
-- Name: applicants; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.applicants (
    id bigint NOT NULL,
    application_period bigint NOT NULL,
    center bigint,
    secondary_school bigint,
    first_name character varying NOT NULL,
    surname character varying NOT NULL,
    other_names character varying,
    title character varying(10) NOT NULL,
    gender public.gender_enum NOT NULL,
    nationality bigint NOT NULL,
    dob date NOT NULL,
    nrc character varying(15) NOT NULL,
    email character varying,
    occupation character varying,
    religion character varying,
    admission_satus smallint DEFAULT 0 NOT NULL,
    payment_status smallint DEFAULT 0 NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    mobile character varying NOT NULL,
    marital_status character varying(20),
    disability bigint,
    application_type character varying NOT NULL,
    number bigint NOT NULL
);


ALTER TABLE public.applicants OWNER TO postgres;

--
-- Name: COLUMN applicants.application_type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.applicants.application_type IS 'Online/Manual';


--
-- Name: COLUMN applicants.number; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.applicants.number IS 'application number to be used for tracking and payments at the pay points';


--
-- Name: applicants_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.applicants ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.applicants_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: application_fee_payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.application_fee_payments (
    id bigint NOT NULL,
    applicant bigint NOT NULL,
    application_number bigint NOT NULL,
    type character varying NOT NULL,
    transaction_id character varying NOT NULL,
    receipt character varying NOT NULL,
    narration character varying,
    amount character varying,
    request text,
    response text,
    extra_data character varying,
    status integer DEFAULT 0,
    created_by bigint,
    created_at integer NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.application_fee_payments OWNER TO postgres;

--
-- Name: COLUMN application_fee_payments.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application_fee_payments.type IS 'Bank or other';


--
-- Name: COLUMN application_fee_payments.amount; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application_fee_payments.amount IS 'Encyrpted. To be viewed using the system only';


--
-- Name: application_fee_payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.application_fee_payments ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.application_fee_payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: application_fees; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.application_fees (
    id bigint NOT NULL,
    type character varying NOT NULL,
    amount double precision DEFAULT 0 NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.application_fees OWNER TO postgres;

--
-- Name: COLUMN application_fees.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application_fees.type IS 'Zambian or International';


--
-- Name: application_fees_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.application_fees ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.application_fees_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: application_period_programes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.application_period_programes (
    id bigint NOT NULL,
    application_period_id bigint NOT NULL,
    program bigint NOT NULL,
    created_by integer NOT NULL,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer,
    "limit" integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.application_period_programes OWNER TO postgres;

--
-- Name: COLUMN application_period_programes."limit"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.application_period_programes."limit" IS 'How many students can be admitted in this programe in a given intake/academic session';


--
-- Name: application_period_programes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.application_period_programes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.application_period_programes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: application_periods; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.application_periods (
    id bigint NOT NULL,
    intake bigint NOT NULL,
    start_date integer NOT NULL,
    closing_date integer NOT NULL,
    created_by integer NOT NULL,
    updated_by integer,
    name character varying NOT NULL
);


ALTER TABLE public.application_periods OWNER TO postgres;

--
-- Name: application_periods_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.application_periods ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.application_periods_id_seq
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
-- Name: campuses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.campuses (
    id bigint NOT NULL,
    name text NOT NULL,
    code text,
    address text,
    created_by integer,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.campuses OWNER TO postgres;

--
-- Name: campus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.campuses ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.campus_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: centres; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.centres (
    id bigint NOT NULL,
    district bigint NOT NULL,
    name text NOT NULL,
    description text,
    phone character(15)[],
    address text,
    created_by integer NOT NULL,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.centres OWNER TO postgres;

--
-- Name: centres_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.centres ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.centres_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: comments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.comments (
    id bigint NOT NULL,
    code character varying NOT NULL,
    description character varying NOT NULL,
    can_continue public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    can_graduate public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    increment public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    carrying public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.comments OWNER TO postgres;

--
-- Name: comments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.comments ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: course_groupings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.course_groupings (
    id bigint NOT NULL,
    course bigint NOT NULL,
    study_mode bigint NOT NULL,
    study_year_session bigint NOT NULL,
    major bigint,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer,
    "Elective" public.yes_no_enum DEFAULT 'No'::public.yes_no_enum NOT NULL
);


ALTER TABLE public.course_groupings OWNER TO postgres;

--
-- Name: course_groupings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.course_groupings ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.course_groupings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: course_staff; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.course_staff (
    id bigint NOT NULL,
    course bigint NOT NULL,
    "user" bigint NOT NULL,
    type character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.course_staff OWNER TO postgres;

--
-- Name: COLUMN course_staff.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.course_staff.type IS 'Coordinator or Lecturer';


--
-- Name: course_staff_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.course_staff ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.course_staff_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: courses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.courses (
    id bigint NOT NULL,
    study bigint NOT NULL,
    grading_system bigint NOT NULL,
    exam_structure bigint NOT NULL,
    type character varying,
    weight character varying DEFAULT 'Half'::character varying NOT NULL,
    code character varying(10) NOT NULL,
    name character varying NOT NULL,
    credits integer,
    created_by bigint NOT NULL,
    created_at integer NOT NULL,
    updated_by bigint,
    updated_at integer,
    lms_status character varying(15)
);


ALTER TABLE public.courses OWNER TO postgres;

--
-- Name: COLUMN courses.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.courses.type IS 'Lab, Taught, project etc';


--
-- Name: COLUMN courses.weight; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.courses.weight IS 'Half course or Full course';


--
-- Name: courses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.courses ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.courses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: departments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.departments (
    id bigint NOT NULL,
    school bigint NOT NULL,
    name text NOT NULL,
    created_by integer,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer,
    head integer,
    code character varying(45)
);


ALTER TABLE public.departments OWNER TO postgres;

--
-- Name: departments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.departments ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.departments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: disabilities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.disabilities (
    id bigint NOT NULL,
    name character varying NOT NULL,
    description text,
    created_by bigint NOT NULL,
    updated_by bigint NOT NULL,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.disabilities OWNER TO postgres;

--
-- Name: disabilities_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.disabilities ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.disabilities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: districts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.districts (
    id bigint NOT NULL,
    province bigint NOT NULL,
    name text NOT NULL,
    created_by integer NOT NULL,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.districts OWNER TO postgres;

--
-- Name: districts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.districts ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.districts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: examination_structure_components; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.examination_structure_components (
    id bigint NOT NULL,
    examination_structure bigint NOT NULL,
    component_type bigint,
    name character varying NOT NULL,
    applicable character varying(45) NOT NULL,
    weight integer NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    crerated_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.examination_structure_components OWNER TO postgres;

--
-- Name: examination_structure_component_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.examination_structure_components ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.examination_structure_component_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: examination_structure_component_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.examination_structure_component_types (
    id bigint NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.examination_structure_component_types OWNER TO postgres;

--
-- Name: examination_structure_component_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.examination_structure_component_types ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.examination_structure_component_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: examination_structures; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.examination_structures (
    id bigint NOT NULL,
    school bigint NOT NULL,
    " code" character varying(45) NOT NULL,
    description text,
    components integer DEFAULT 1 NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.examination_structures OWNER TO postgres;

--
-- Name: examination_structure_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.examination_structures ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.examination_structure_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: fee_categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fee_categories (
    id bigint NOT NULL,
    code character varying(8) NOT NULL,
    name character varying(45) NOT NULL,
    created_by integer,
    updated_by integer,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.fee_categories OWNER TO postgres;

--
-- Name: fee_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.fee_categories ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.fee_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: fee_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fee_types (
    id bigint NOT NULL,
    code character varying(8),
    name character varying(45) NOT NULL,
    created_by integer,
    updated_by integer,
    created_at integer,
    updated_at integer,
    course_fee character varying(3),
    graduation_fee character varying(3)
);


ALTER TABLE public.fee_types OWNER TO postgres;

--
-- Name: grading_system_grades; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.grading_system_grades (
    id bigint NOT NULL,
    grading_system bigint NOT NULL,
    grade character varying(10) NOT NULL,
    min_marks double precision NOT NULL,
    max_marks double precision NOT NULL,
    points double precision,
    comment character varying(45) NOT NULL,
    has_passed public.yes_no_enum NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.grading_system_grades OWNER TO postgres;

--
-- Name: grading_system_grades_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.grading_system_grades ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.grading_system_grades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: grading_systems; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.grading_systems (
    id bigint NOT NULL,
    school bigint NOT NULL,
    name character varying NOT NULL,
    description text,
    status public.yes_no_enum DEFAULT 'Yes'::public.yes_no_enum,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.grading_systems OWNER TO postgres;

--
-- Name: grading_systems_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.grading_systems ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.grading_systems_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: hostel_blocks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hostel_blocks (
    id bigint NOT NULL,
    hostel bigint NOT NULL,
    code character varying NOT NULL,
    description text,
    floors integer,
    created_by bigint NOT NULL,
    updated_by bigint NOT NULL,
    created_at integer,
    updated_at integer,
    sex character varying
);


ALTER TABLE public.hostel_blocks OWNER TO postgres;

--
-- Name: hostel_blocks_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.hostel_blocks ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.hostel_blocks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: hostels; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hostels (
    id bigint NOT NULL,
    campus bigint NOT NULL,
    code character varying NOT NULL,
    type character varying NOT NULL,
    description text,
    created_by bigint NOT NULL,
    updated_by bigint NOT NULL,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.hostels OWNER TO postgres;

--
-- Name: hostels_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.hostels ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.hostels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: national_groupings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.national_groupings (
    id bigint NOT NULL,
    code character varying(5) NOT NULL,
    name character varying(45) NOT NULL,
    created_by integer NOT NULL,
    updated_by integer,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.national_groupings OWNER TO postgres;

--
-- Name: national_groupings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.national_groupings ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.national_groupings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: nationalities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nationalities (
    id bigint NOT NULL,
    name character varying(45) NOT NULL,
    iso_code character varying(5),
    created_by integer,
    updated_by integer,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.nationalities OWNER TO postgres;

--
-- Name: nationalities_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.nationalities ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.nationalities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: offences; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.offences (
    id bigint NOT NULL,
    name character varying(45) NOT NULL,
    description text,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.offences OWNER TO postgres;

--
-- Name: study_paths; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.study_paths (
    id bigint NOT NULL,
    code character varying(10) NOT NULL,
    description character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.study_paths OWNER TO postgres;

--
-- Name: path_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.study_paths ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.path_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payments (
    id bigint NOT NULL,
    student bigint NOT NULL,
    session bigint NOT NULL,
    type character varying NOT NULL,
    transaction_id character varying NOT NULL,
    receipt character varying NOT NULL,
    narration character varying,
    amount character varying NOT NULL,
    request text,
    response text,
    extra_data character varying,
    status integer DEFAULT 0 NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.payments OWNER TO postgres;

--
-- Name: COLUMN payments.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.payments.type IS 'Bank payment, Manual payment etc';


--
-- Name: COLUMN payments.amount; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.payments.amount IS 'Encrypted. Can only be viewed using the system';


--
-- Name: payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.payments ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: program_classes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.program_classes (
    id bigint NOT NULL,
    code character varying NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.program_classes OWNER TO postgres;

--
-- Name: program_classes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.program_classes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.program_classes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: programs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.programs (
    id bigint NOT NULL,
    department bigint NOT NULL,
    class bigint NOT NULL,
    category bigint NOT NULL,
    name character varying NOT NULL,
    abbreviation character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer,
    code character varying NOT NULL,
    study_structure bigint NOT NULL
);


ALTER TABLE public.programs OWNER TO postgres;

--
-- Name: provinces; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.provinces (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.provinces OWNER TO postgres;

--
-- Name: province_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.provinces ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.province_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: room_properties; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.room_properties (
    id bigint NOT NULL,
    type bigint NOT NULL,
    room bigint NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint NOT NULL,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.room_properties OWNER TO postgres;

--
-- Name: room_properties_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.room_properties ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.room_properties_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: room_property_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.room_property_types (
    id bigint NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint NOT NULL,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.room_property_types OWNER TO postgres;

--
-- Name: room_property_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.room_property_types ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.room_property_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: room_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.room_types (
    id bigint NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint NOT NULL,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.room_types OWNER TO postgres;

--
-- Name: room_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.room_types ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.room_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: rooms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rooms (
    id bigint NOT NULL,
    hostel_block bigint NOT NULL,
    number character varying NOT NULL,
    type bigint NOT NULL,
    bed_spaces integer,
    available_bedspaces integer,
    floor character varying NOT NULL,
    status character varying DEFAULT 'Not allocated'::character varying NOT NULL,
    occupied public.yes_no_enum DEFAULT 'No'::public.yes_no_enum NOT NULL,
    reserved public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    student_category character varying DEFAULT 'Undergraduates'::character varying NOT NULL,
    sex character varying DEFAULT 'default'::character varying NOT NULL,
    remarks character varying,
    created_by bigint NOT NULL,
    updated_by bigint NOT NULL,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.rooms OWNER TO postgres;

--
-- Name: rooms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.rooms ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.rooms_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: schools; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.schools (
    id integer NOT NULL,
    number text NOT NULL,
    name text NOT NULL,
    description text,
    created_by integer,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer,
    campus bigint NOT NULL
);


ALTER TABLE public.schools OWNER TO postgres;

--
-- Name: COLUMN schools.number; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.schools.number IS 'This should be generated by the system where possible';


--
-- Name: school_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.schools ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.school_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: secondary_school_subjects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.secondary_school_subjects (
    id bigint NOT NULL,
    name character varying NOT NULL,
    shortname character varying,
    created_by integer NOT NULL,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer,
    type character varying NOT NULL
);


ALTER TABLE public.secondary_school_subjects OWNER TO postgres;

--
-- Name: COLUMN secondary_school_subjects.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.secondary_school_subjects.type IS 'O-Level Or A-Level';


--
-- Name: secondary_school_subjects_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.secondary_school_subjects ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.secondary_school_subjects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: secondary_schools; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.secondary_schools (
    id bigint NOT NULL,
    district bigint NOT NULL,
    name text NOT NULL,
    code character varying(15),
    type character varying(45) NOT NULL,
    gender character varying(45) NOT NULL,
    address text,
    created_by integer NOT NULL,
    updated_by integer,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.secondary_schools OWNER TO postgres;

--
-- Name: secondary_schools_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.secondary_schools ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.secondary_schools_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_session_invoices; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_session_invoices (
    id bigint NOT NULL,
    student bigint NOT NULL,
    fee bigint NOT NULL,
    amount character varying NOT NULL,
    paid_amount character varying,
    invoice_number character varying,
    created_at integer NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.student_session_invoices OWNER TO postgres;

--
-- Name: COLUMN student_session_invoices.amount; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.student_session_invoices.amount IS 'Encrypted.To be viewed only using the system';


--
-- Name: session_fees_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_session_invoices ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.session_fees_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: session_minimum_tuition_payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.session_minimum_tuition_payments (
    id bigint NOT NULL,
    session bigint NOT NULL,
    programe_class bigint NOT NULL,
    student_category bigint NOT NULL,
    created_by bigint NOT NULL,
    created_at integer NOT NULL,
    updated_by bigint,
    updated_at integer
);


ALTER TABLE public.session_minimum_tuition_payments OWNER TO postgres;

--
-- Name: session_minimum_tuition_payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.session_minimum_tuition_payments ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.session_minimum_tuition_payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: session_payment_plans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.session_payment_plans (
    id bigint NOT NULL,
    session bigint NOT NULL,
    percentage double precision NOT NULL,
    created_by bigint NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    updated_by bigint,
    payment_date date NOT NULL
);


ALTER TABLE public.session_payment_plans OWNER TO postgres;

--
-- Name: session_payment_plans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.session_payment_plans ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.session_payment_plans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: session_registration_periods; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.session_registration_periods (
    id bigint NOT NULL,
    academic_session bigint NOT NULL,
    registration_start_date integer NOT NULL,
    registration_end_date integer NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.session_registration_periods OWNER TO postgres;

--
-- Name: session_registration_periods_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.session_registration_periods ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.session_registration_periods_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.academic_sessions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.sessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: sponsors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sponsors (
    id bigint NOT NULL,
    name character varying NOT NULL,
    contact_person_names character varying,
    contact_person_phone character varying(15),
    contact_person_email character varying,
    created_by integer NOT NULL,
    updated_by integer,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.sponsors OWNER TO postgres;

--
-- Name: sponsorship_percentages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sponsorship_percentages (
    id bigint NOT NULL,
    sponsor bigint NOT NULL,
    fee bigint NOT NULL,
    percentage double precision DEFAULT 0 NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.sponsorship_percentages OWNER TO postgres;

--
-- Name: sponsorship_percentages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.sponsorship_percentages ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.sponsorship_percentages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_categories (
    id bigint NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.student_categories OWNER TO postgres;

--
-- Name: student_categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_categories ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_comments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_comments (
    id bigint NOT NULL,
    student bigint NOT NULL,
    session bigint NOT NULL,
    comment bigint NOT NULL,
    results_status character varying NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.student_comments OWNER TO postgres;

--
-- Name: COLUMN student_comments.results_status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.student_comments.results_status IS 'Withheld,Published';


--
-- Name: student_comments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_comments ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_course_enrolments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_course_enrolments (
    id bigint NOT NULL,
    session bigint NOT NULL,
    student bigint NOT NULL,
    course bigint NOT NULL,
    grade character varying,
    examination_marks double precision DEFAULT 0,
    ca_marks double precision DEFAULT 0,
    total_marks double precision DEFAULT 0,
    is_deffered public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    is_supplimentary public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    passed public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    passed_exam public.yes_no_enum DEFAULT 'No'::public.yes_no_enum,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.student_course_enrolments OWNER TO postgres;

--
-- Name: COLUMN student_course_enrolments.grade; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.student_course_enrolments.grade IS 'To be encrypted. Can only be viewed via the system';


--
-- Name: student_course_enrolments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_course_enrolments ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_course_enrolments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_files; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_files (
    id bigint NOT NULL,
    student bigint NOT NULL,
    name character varying NOT NULL,
    file character varying NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.student_files OWNER TO postgres;

--
-- Name: student_files_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_files ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_guardian; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_guardian (
    id bigint NOT NULL,
    student bigint NOT NULL,
    first_name character varying NOT NULL,
    surname character varying NOT NULL,
    relation character varying NOT NULL,
    mobile character varying(16),
    email character varying,
    district bigint,
    residential_address text,
    alternative_phone character varying(20),
    created_at integer NOT NULL,
    updated_at integer,
    created_by bigint NOT NULL,
    updated_by bigint
);


ALTER TABLE public.student_guardian OWNER TO postgres;

--
-- Name: student_guardian_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_guardian ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_guardian_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_location; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_location (
    id bigint NOT NULL,
    student bigint NOT NULL,
    district bigint NOT NULL,
    residential_address text,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.student_location OWNER TO postgres;

--
-- Name: student_location_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_location ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_location_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_offences; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_offences (
    id bigint NOT NULL,
    student bigint NOT NULL,
    offence bigint NOT NULL,
    session bigint NOT NULL,
    is_cleared public.yes_no_enum DEFAULT 'No'::public.yes_no_enum NOT NULL,
    cleared_by bigint,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.student_offences OWNER TO postgres;

--
-- Name: student_offences_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.offences ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_offences_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_offences_id_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_offences ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_offences_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_previous_institution; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_previous_institution (
    id bigint NOT NULL,
    student bigint NOT NULL,
    institution character varying NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.student_previous_institution OWNER TO postgres;

--
-- Name: student_previous_institution_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.applicant_previous_institution ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_previous_institution_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_previous_institution_id_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_previous_institution ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_previous_institution_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_programes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_programes (
    id bigint NOT NULL,
    student bigint NOT NULL,
    program bigint NOT NULL,
    choice integer NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    created_by bigint NOT NULL,
    updated_by bigint
);


ALTER TABLE public.student_programes OWNER TO postgres;

--
-- Name: student_programes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_programes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_programes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_references; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_references (
    id bigint NOT NULL,
    student bigint NOT NULL,
    type character varying NOT NULL,
    name character varying NOT NULL,
    "position" character varying NOT NULL,
    email character varying NOT NULL,
    phone character varying NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.student_references OWNER TO postgres;

--
-- Name: COLUMN student_references.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.student_references.type IS 'Academic or Professional';


--
-- Name: student_references_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_references ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_references_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_registrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_registrations (
    id bigint NOT NULL,
    student bigint NOT NULL,
    session bigint NOT NULL,
    status character varying NOT NULL,
    previous_status text,
    created_at bigint NOT NULL,
    created_by bigint,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.student_registrations OWNER TO postgres;

--
-- Name: COLUMN student_registrations.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.student_registrations.status IS 'Registered, Deregistered, Pending payment, Pending Course submission ';


--
-- Name: student_sponsors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_sponsors (
    id bigint NOT NULL,
    student bigint NOT NULL,
    sponsor bigint NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint
);


ALTER TABLE public.student_sponsors OWNER TO postgres;

--
-- Name: student_sponsors_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.sponsors ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_sponsors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_sponsors_id_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_sponsors ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_sponsors_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_study_records; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_study_records (
    id bigint NOT NULL,
    intake bigint NOT NULL,
    program bigint NOT NULL,
    status character varying NOT NULL,
    created_by bigint NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    updated_by bigint,
    student bigint NOT NULL
);


ALTER TABLE public.student_study_records OWNER TO postgres;

--
-- Name: COLUMN student_study_records.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.student_study_records.status IS 'Current,Previous. If student changed programs, we change the new program record as Current and keep the previous record also';


--
-- Name: student_study_records_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_study_records ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_study_records_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_study_years; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_study_years (
    id bigint NOT NULL,
    student bigint NOT NULL,
    session bigint NOT NULL,
    study_year bigint NOT NULL,
    description text
);


ALTER TABLE public.student_study_years OWNER TO postgres;

--
-- Name: student_study_years_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_study_years ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_study_years_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_subjects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_subjects (
    id bigint NOT NULL,
    student bigint NOT NULL,
    subject bigint NOT NULL,
    grade integer NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    created_by bigint NOT NULL,
    updated_by bigint
);


ALTER TABLE public.student_subjects OWNER TO postgres;

--
-- Name: student_subjects_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.applicant_subjects ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_subjects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_subjects_id_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_subjects ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_subjects_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.student_type (
    id bigint NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.student_type OWNER TO postgres;

--
-- Name: student_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.student_type ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: students; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.students (
    number bigint NOT NULL,
    applicant bigint NOT NULL,
    center bigint,
    secondary_school bigint,
    disability bigint,
    category bigint NOT NULL,
    nationality bigint NOT NULL,
    type bigint NOT NULL,
    first_name character varying NOT NULL,
    surname character varying NOT NULL,
    other_names character varying,
    title character varying(10) NOT NULL,
    gender character varying NOT NULL,
    dob date NOT NULL,
    nrc character varying(15) NOT NULL,
    email character varying,
    occupation character varying,
    religion character varying,
    marital_status character varying(20),
    refugee character varying,
    mobile character varying(15),
    is_staff_child public.yes_no_enum DEFAULT 'No'::public.yes_no_enum NOT NULL,
    staff bigint,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_at integer,
    updated_by bigint,
    active integer DEFAULT 0 NOT NULL,
    id bigint NOT NULL,
    auth_key character varying(45) NOT NULL,
    password_hash text NOT NULL,
    password_reset_token text,
    verification_token text,
    ip_address text,
    login_attempts integer DEFAULT 0,
    last_login timestamp without time zone,
    lms_account_created public.yes_no_enum DEFAULT 'No'::public.yes_no_enum
);


ALTER TABLE public.students OWNER TO postgres;

--
-- Name: COLUMN students.active; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.students.active IS 'Active=1, inactive=0(should change the password), blocked=2, account locked =3';


--
-- Name: students_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.students ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.students_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: studies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.studies (
    id bigint NOT NULL,
    program bigint NOT NULL,
    code character varying,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer,
    progression_threshold double precision NOT NULL
);


ALTER TABLE public.studies OWNER TO postgres;

--
-- Name: COLUMN studies.progression_threshold; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.studies.progression_threshold IS 'Percentage of course a student needs to clear to progress to the next study year';


--
-- Name: studies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.studies ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.studies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: study_course_loads; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.study_course_loads (
    id bigint NOT NULL,
    study bigint NOT NULL,
    load integer NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.study_course_loads OWNER TO postgres;

--
-- Name: study_course_loads_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.study_course_loads ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.study_course_loads_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: study_majors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.study_majors (
    id bigint NOT NULL,
    study bigint NOT NULL,
    minor bigint,
    type character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.study_majors OWNER TO postgres;

--
-- Name: COLUMN study_majors.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.study_majors.type IS 'Single, Double or Major/Minor';


--
-- Name: study_majors_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.study_majors ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.study_majors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: study_modes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.study_modes (
    id bigint NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.study_modes OWNER TO postgres;

--
-- Name: study_modes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.study_modes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.study_modes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: study_structures; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.study_structures (
    id bigint NOT NULL,
    study_path bigint NOT NULL,
    name text NOT NULL,
    duration integer NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer,
    status smallint DEFAULT 1,
    can_register_per_course public.yes_no_enum DEFAULT 'No'::public.yes_no_enum
);


ALTER TABLE public.study_structures OWNER TO postgres;

--
-- Name: study_structure_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.study_structures ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.study_structure_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: study_year_session_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.study_year_session_types (
    id bigint NOT NULL,
    name character varying NOT NULL,
    list text NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.study_year_session_types OWNER TO postgres;

--
-- Name: COLUMN study_year_session_types.list; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.study_year_session_types.list IS 'List of study year session names to be used to populate the study year session name as a dropdown. i.e. Semester 1/Semester 2, Term 1/2/3 etc';


--
-- Name: study_year_session_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.study_year_session_types ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.study_year_session_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: study_year_sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.study_year_sessions (
    id bigint NOT NULL,
    type bigint NOT NULL,
    study_year bigint NOT NULL,
    name character varying NOT NULL,
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.study_year_sessions OWNER TO postgres;

--
-- Name: study_year_sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.study_year_sessions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.study_year_sessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: study_years; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.study_years (
    id bigint NOT NULL,
    study_structure bigint NOT NULL,
    name character varying NOT NULL,
    code character varying(10),
    created_by bigint NOT NULL,
    updated_by bigint,
    created_at integer NOT NULL,
    updated_at integer
);


ALTER TABLE public.study_years OWNER TO postgres;

--
-- Name: study_years_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.study_years ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.study_years_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Data for Name: aauth_groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_groups (id, name, description, created_at, updated_at, created_by, updated_by) FROM stdin;
4	Administrator	Administrator group	1670069030	1670670002	\N	1
7	Test	\N	1670680004	1670680004	1	1
\.


--
-- Data for Name: aauth_perm_to_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_perm_to_group (id, permission, "group", created_by, updated_by, created_at, updated_at) FROM stdin;
71	2	7	1	1	1671274704	1671274704
72	4	7	1	1	1671274704	1671274704
73	1	4	1	1	1671285555	1671285555
74	3	4	1	1	1671285555	1671285555
75	13	4	1	1	1671285556	1671285556
76	14	4	1	1	1671285556	1671285556
77	2	4	1	1	1671285556	1671285556
78	4	4	1	1	1671285556	1671285556
\.


--
-- Data for Name: aauth_perm_to_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_perm_to_user (id, permission, "user", active, expiry_date, created_by, created_at, updated_by, updated_at) FROM stdin;
5	14	4	0	2022-12-17 13:00:34	1	1671274798	1	1671274834
\.


--
-- Data for Name: aauth_perms; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_perms (id, name, description, "group") FROM stdin;
1	Manage users	\N	MANAGE
2	View users	\N	VIEW
3	Manage groups	\N	MANAGE
4	View groups	\N	VIEW
13	Manage user to group	\N	MANAGE
14	Assign permission to user	\N	MANAGE
\.


--
-- Data for Name: aauth_user_files; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_user_files (id, "user", name, file, created_by, created_at, updated_by, updated_at) FROM stdin;
\.


--
-- Data for Name: aauth_user_to_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_user_to_group (id, "user", "group", active, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: aauth_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_users (id, "group", first_name, last_name, phone, email, active, auth_key, password_hash, password_reset_token, verification_token, ip_address, login_attempts, updated_by, created_by, created_at, updated_at, man_number, expiry_date, department, username, last_login, lms_account_created, other_name, title) FROM stdin;
1	4	Francis	Chulu	\N	admin@schoolingly.com	1	i8KitNy41PkH21wOeFRvXoZ2lhZqeOLF	$2y$13$1y.T./XcdHKKE6tl7hkIg.ZxaViv3eeQaoJkGD.HLuBG1a6sxBhrS	\N	\N	\N	0	\N	\N	1670069031	1670069031	01234	2023-03-03	5	01234	\N	No	\N	Mr.
4	7	Edson	Chulu	\N	edson@gmail.com	1	i8KitNy41PkH21wOeFRvXoZ2lhZqeOLF	$2y$13$1y.T./XcdHKKE6tl7hkIg.ZxaViv3eeQaoJkGD.HLuBG1a6sxBhrS	\N	\N	\N	0	\N	\N	1670069031	1671301396	12345	2023-03-03	5	12345	\N	Yes	\N	Mr.
\.


--
-- Data for Name: academic_intakes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.academic_intakes (id, study_structure, year, code, description, first_session_start_date, first_session_end_date, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: academic_sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.academic_sessions (id, intake, code, name, start_date, end_date, last_year, created_by, updated_by, created_at, updated_at, academic_year) FROM stdin;
\.


--
-- Data for Name: admission_eligibility; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admission_eligibility (id, program, intake, required_subjects, worst_grade, created_by, created_at, updated_by, updated_at) FROM stdin;
\.


--
-- Data for Name: admission_eligibility_required_subjects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admission_eligibility_required_subjects (id, program, subject, intake, created_by, created_at, updated_by, worst_grade, updated_at) FROM stdin;
\.


--
-- Data for Name: applicant_files; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.applicant_files (id, applicant, name, file, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: applicant_guardian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.applicant_guardian (id, applicant, first_name, surname, relation, mobile, email, district, residential_address, alternative_phone, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: applicant_location; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.applicant_location (id, applicant, district, residential_address, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: applicant_previous_institution; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.applicant_previous_institution (id, applicant, institution, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: applicant_programs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.applicant_programs (id, applicant, program, choice, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: applicant_references; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.applicant_references (id, applicant, type, name, "position", email, phone, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: applicant_subjects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.applicant_subjects (id, applicant, subject, grade, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: applicants; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.applicants (id, application_period, center, secondary_school, first_name, surname, other_names, title, gender, nationality, dob, nrc, email, occupation, religion, admission_satus, payment_status, created_at, updated_at, mobile, marital_status, disability, application_type, number) FROM stdin;
\.


--
-- Data for Name: application_fee_payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.application_fee_payments (id, applicant, application_number, type, transaction_id, receipt, narration, amount, request, response, extra_data, status, created_by, created_at, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: application_fees; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.application_fees (id, type, amount, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: application_period_programes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.application_period_programes (id, application_period_id, program, created_by, updated_by, created_at, updated_at, "limit") FROM stdin;
\.


--
-- Data for Name: application_periods; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.application_periods (id, intake, start_date, closing_date, created_by, updated_by, name) FROM stdin;
\.


--
-- Data for Name: audit_logs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audit_logs (id, "user", action, extra_data, date, ip_address, user_agent) FROM stdin;
1	1	Created user group:test		1670667537	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
2	1	Updated user group:Administrator		1670670002	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
3	1	Updated user group:Administrator		1670670034	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
4	1	Updated user group:Administrator		1670670042	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
5	1	Updated user group:test		1670672445	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
6	1	Delete user group:test with its associated permissions		1670672461	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
7	1	Updated user group:Administrator		1670672562	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
8	1	Updated user group:Administrator		1670676995	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
9	1	Updated user group:Administrator		1670677205	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
10	1	Updated user group:Administrator		1670678771	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
11	1	Created user group:Test		1670680004	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
12	1	Attached user(id:1) with man number:01234 to user group:Administrator		1670682493	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
13	1	Attached user(id:1) with man number:01234 to user group:Test		1670682836	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
14	1	Deactivated user to group assignment. User:01234, group:Test		1670696515	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
15	1	Activated user to group assignment. User(1)01234, group:Test		1670696601	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
16	1	Deleted user to group assignment. User:1, group:Test		1670696946	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
17	1	Attached user(id:1) with man number:01234 to user group:Test		1670697161	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
18	1	Updated user group:Test		1670760047	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
19	1	Deactivated user to group assignment. User(1) man number:01234, group:Test		1670773433	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
20	1	Activated user to group assignment. User(1) man number:01234, group:Test		1670773439	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
21	1	Updated user group:Administrator		1670788033	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
22	1	Assigned user(id:1) with man number:01234 permission:Assign permission to user		1670792377	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
23	1	Revoked user permission. User(1) man number:01234, permission:Assign permission to user		1670792414	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
24	1	Revoked user permission. User(1) man number:01234, permission:Assign permission to user		1670792466	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
25	1	Revoked user permission. User(1) man number:01234, permission:Assign permission to user		1670792572	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
26	1	Extended permission assignment for User(1) man number:01234, permission:Assign permission to user to date:2022-12-12 23:03:08		1670792588	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
27	1	Revoked user permission. User(1) man number:01234, permission:Assign permission to user		1670792636	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
28	1	Revoked user permission. User(1) man number:01234, permission:Assign permission to user		1670792648	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
29	1	Assigned user(id:1) with man number:01234 permission:View groups		1670793504	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
30	1	Assigned user(id:1) with man number:01234 permission:Manage users		1670794059	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
31	1	Revoked user permission. User(1) man number:01234, permission:Manage users		1670794064	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
32	1	Extended permission assignment for User(1) man number:01234, permission:Manage users to date:2022-12-12 23:32:16		1670794336	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
33	1	Revoked user permission. User(1) man number:01234, permission:Manage users		1670794342	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
34	1	Deleted user permission assignment. User(1) man no:01234, permission:Manage users		1670794378	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
35	1	Assigned user(id:1) with man number:01234 permission:View users		1671267002	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
36	1	Updated user group:Administrator		1671267390	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
37	1	Updated user group:Administrator		1671267404	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
38	1	Updated user group:Test		1671267418	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
39	1	Deleted user to group assignment. User(1) man no:01234, group:Test		1671272508	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
40	1	Updated user group:Administrator		1671274663	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
41	1	Deleted user permission assignment. User(1) man no:01234, permission:View users		1671274673	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
42	1	Updated user group:Test		1671274704	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
43	1	Assigned user(id:4) with man number:12345 permission:Assign permission to user		1671274798	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
44	1	Revoked user permission. User(4) man number:12345, permission:Assign permission to user		1671274834	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
45	1	Updated user group:Administrator		1671285556	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0
\.


--
-- Data for Name: campuses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.campuses (id, name, code, address, created_by, updated_by, created_at, updated_at) FROM stdin;
5	Main	Main	Main campus	\N	\N	1670069030	1670069030
\.


--
-- Data for Name: centres; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.centres (id, district, name, description, phone, address, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: comments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.comments (id, code, description, can_continue, can_graduate, increment, carrying, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: course_groupings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.course_groupings (id, course, study_mode, study_year_session, major, created_by, updated_by, created_at, updated_at, "Elective") FROM stdin;
\.


--
-- Data for Name: course_staff; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.course_staff (id, course, "user", type, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: courses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.courses (id, study, grading_system, exam_structure, type, weight, code, name, credits, created_by, created_at, updated_by, updated_at, lms_status) FROM stdin;
\.


--
-- Data for Name: departments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.departments (id, school, name, created_by, updated_by, created_at, updated_at, head, code) FROM stdin;
5	5	Information Technology	\N	\N	1670069030	1670069030	\N	IT
\.


--
-- Data for Name: disabilities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.disabilities (id, name, description, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: districts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.districts (id, province, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: examination_structure_component_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.examination_structure_component_types (id, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: examination_structure_components; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.examination_structure_components (id, examination_structure, component_type, name, applicable, weight, created_by, updated_by, crerated_at, updated_at) FROM stdin;
\.


--
-- Data for Name: examination_structures; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.examination_structures (id, school, " code", description, components, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: fee_categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fee_categories (id, code, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: fee_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fee_types (id, code, name, created_by, updated_by, created_at, updated_at, course_fee, graduation_fee) FROM stdin;
\.


--
-- Data for Name: grading_system_grades; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.grading_system_grades (id, grading_system, grade, min_marks, max_marks, points, comment, has_passed, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: grading_systems; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.grading_systems (id, school, name, description, status, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: hostel_blocks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hostel_blocks (id, hostel, code, description, floors, created_by, updated_by, created_at, updated_at, sex) FROM stdin;
\.


--
-- Data for Name: hostels; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hostels (id, campus, code, type, description, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: national_groupings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.national_groupings (id, code, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: nationalities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.nationalities (id, name, iso_code, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: offences; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.offences (id, name, description, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (id, student, session, type, transaction_id, receipt, narration, amount, request, response, extra_data, status, created_at, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: program_classes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.program_classes (id, code, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: programs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.programs (id, department, class, category, name, abbreviation, created_by, updated_by, created_at, updated_at, code, study_structure) FROM stdin;
\.


--
-- Data for Name: provinces; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.provinces (id, name) FROM stdin;
\.


--
-- Data for Name: room_properties; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.room_properties (id, type, room, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: room_property_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.room_property_types (id, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: room_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.room_types (id, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: rooms; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rooms (id, hostel_block, number, type, bed_spaces, available_bedspaces, floor, status, occupied, reserved, student_category, sex, remarks, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: schools; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.schools (id, number, name, description, created_by, updated_by, created_at, updated_at, campus) FROM stdin;
5	01	NS	Natural Sciences	\N	\N	1670069030	1670069030	5
\.


--
-- Data for Name: secondary_school_subjects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.secondary_school_subjects (id, name, shortname, created_by, updated_by, created_at, updated_at, type) FROM stdin;
\.


--
-- Data for Name: secondary_schools; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.secondary_schools (id, district, name, code, type, gender, address, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: session_minimum_tuition_payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.session_minimum_tuition_payments (id, session, programe_class, student_category, created_by, created_at, updated_by, updated_at) FROM stdin;
\.


--
-- Data for Name: session_payment_plans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.session_payment_plans (id, session, percentage, created_by, created_at, updated_at, updated_by, payment_date) FROM stdin;
\.


--
-- Data for Name: session_registration_periods; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.session_registration_periods (id, academic_session, registration_start_date, registration_end_date, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: sponsors; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sponsors (id, name, contact_person_names, contact_person_phone, contact_person_email, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: sponsorship_percentages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sponsorship_percentages (id, sponsor, fee, percentage, created_at, created_by, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_categories (id, name) FROM stdin;
\.


--
-- Data for Name: student_comments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_comments (id, student, session, comment, results_status, created_at, created_by, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_course_enrolments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_course_enrolments (id, session, student, course, grade, examination_marks, ca_marks, total_marks, is_deffered, is_supplimentary, passed, passed_exam, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: student_files; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_files (id, student, name, file, created_at, created_by, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_guardian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_guardian (id, student, first_name, surname, relation, mobile, email, district, residential_address, alternative_phone, created_at, updated_at, created_by, updated_by) FROM stdin;
\.


--
-- Data for Name: student_location; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_location (id, student, district, residential_address, created_at, created_by, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_offences; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_offences (id, student, offence, session, is_cleared, cleared_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: student_previous_institution; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_previous_institution (id, student, institution, created_at, created_by, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_programes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_programes (id, student, program, choice, created_at, updated_at, created_by, updated_by) FROM stdin;
\.


--
-- Data for Name: student_references; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_references (id, student, type, name, "position", email, phone, created_at, created_by, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_registrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_registrations (id, student, session, status, previous_status, created_at, created_by, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_session_invoices; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_session_invoices (id, student, fee, amount, paid_amount, invoice_number, created_at, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_sponsors; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_sponsors (id, student, sponsor, created_at, created_by, updated_at, updated_by) FROM stdin;
\.


--
-- Data for Name: student_study_records; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_study_records (id, intake, program, status, created_by, created_at, updated_at, updated_by, student) FROM stdin;
\.


--
-- Data for Name: student_study_years; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_study_years (id, student, session, study_year, description) FROM stdin;
\.


--
-- Data for Name: student_subjects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_subjects (id, student, subject, grade, created_at, updated_at, created_by, updated_by) FROM stdin;
\.


--
-- Data for Name: student_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.student_type (id, name) FROM stdin;
\.


--
-- Data for Name: students; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.students (number, applicant, center, secondary_school, disability, category, nationality, type, first_name, surname, other_names, title, gender, dob, nrc, email, occupation, religion, marital_status, refugee, mobile, is_staff_child, staff, created_at, created_by, updated_at, updated_by, active, id, auth_key, password_hash, password_reset_token, verification_token, ip_address, login_attempts, last_login, lms_account_created) FROM stdin;
\.


--
-- Data for Name: studies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.studies (id, program, code, name, created_by, updated_by, created_at, updated_at, progression_threshold) FROM stdin;
\.


--
-- Data for Name: study_course_loads; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.study_course_loads (id, study, load, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: study_majors; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.study_majors (id, study, minor, type, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: study_modes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.study_modes (id, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: study_paths; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.study_paths (id, code, description, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: study_structures; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.study_structures (id, study_path, name, duration, created_by, updated_by, created_at, updated_at, status, can_register_per_course) FROM stdin;
\.


--
-- Data for Name: study_year_session_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.study_year_session_types (id, name, list, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: study_year_sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.study_year_sessions (id, type, study_year, name, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: study_years; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.study_years (id, study_structure, name, code, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- Name: aauth_groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_groups_id_seq', 7, true);


--
-- Name: aauth_perm_to_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_perm_to_group_id_seq', 78, true);


--
-- Name: aauth_perm_to_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_perm_to_user_id_seq', 5, true);


--
-- Name: aauth_perms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_perms_id_seq', 14, true);


--
-- Name: aauth_user_files_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_user_files_id_seq', 1, false);


--
-- Name: aauth_user_to_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_user_to_group_id_seq', 6, true);


--
-- Name: aauth_users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_users_id_seq', 4, true);


--
-- Name: academic_intakes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.academic_intakes_id_seq', 1, false);


--
-- Name: admission_criteria_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admission_criteria_id_seq', 1, false);


--
-- Name: admission_eligibility_required_subjects_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.admission_eligibility_required_subjects_id_seq', 1, false);


--
-- Name: applicant_files_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.applicant_files_id_seq', 1, false);


--
-- Name: applicant_guardian_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.applicant_guardian_id_seq', 1, false);


--
-- Name: applicant_location_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.applicant_location_id_seq', 1, false);


--
-- Name: applicant_programs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.applicant_programs_id_seq', 1, false);


--
-- Name: applicant_references_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.applicant_references_id_seq', 1, false);


--
-- Name: applicants_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.applicants_id_seq', 1, false);


--
-- Name: application_fee_payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.application_fee_payments_id_seq', 1, false);


--
-- Name: application_fees_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.application_fees_id_seq', 1, false);


--
-- Name: application_period_programes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.application_period_programes_id_seq', 1, false);


--
-- Name: application_periods_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.application_periods_id_seq', 1, false);


--
-- Name: audit_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.audit_logs_id_seq', 45, true);


--
-- Name: campus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.campus_id_seq', 5, true);


--
-- Name: centres_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.centres_id_seq', 1, false);


--
-- Name: comments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.comments_id_seq', 1, false);


--
-- Name: course_groupings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.course_groupings_id_seq', 1, false);


--
-- Name: course_staff_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.course_staff_id_seq', 1, false);


--
-- Name: courses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.courses_id_seq', 1, false);


--
-- Name: departments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.departments_id_seq', 5, true);


--
-- Name: disabilities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.disabilities_id_seq', 1, false);


--
-- Name: districts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.districts_id_seq', 1, false);


--
-- Name: examination_structure_component_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.examination_structure_component_id_seq', 1, false);


--
-- Name: examination_structure_component_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.examination_structure_component_types_id_seq', 1, false);


--
-- Name: examination_structure_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.examination_structure_id_seq', 1, false);


--
-- Name: fee_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fee_categories_id_seq', 1, false);


--
-- Name: grading_system_grades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.grading_system_grades_id_seq', 1, false);


--
-- Name: grading_systems_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.grading_systems_id_seq', 1, false);


--
-- Name: hostel_blocks_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hostel_blocks_id_seq', 1, false);


--
-- Name: hostels_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hostels_id_seq', 1, false);


--
-- Name: national_groupings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.national_groupings_id_seq', 1, false);


--
-- Name: nationalities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nationalities_id_seq', 1, false);


--
-- Name: path_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.path_id_seq', 1, false);


--
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_id_seq', 1, false);


--
-- Name: program_classes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.program_classes_id_seq', 1, false);


--
-- Name: province_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.province_id_seq', 1, false);


--
-- Name: room_properties_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.room_properties_id_seq', 1, false);


--
-- Name: room_property_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.room_property_types_id_seq', 1, false);


--
-- Name: room_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.room_types_id_seq', 1, false);


--
-- Name: rooms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rooms_id_seq', 1, false);


--
-- Name: school_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.school_id_seq', 5, true);


--
-- Name: secondary_school_subjects_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.secondary_school_subjects_id_seq', 1, false);


--
-- Name: secondary_schools_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.secondary_schools_id_seq', 1, false);


--
-- Name: session_fees_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.session_fees_id_seq', 1, false);


--
-- Name: session_minimum_tuition_payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.session_minimum_tuition_payments_id_seq', 1, false);


--
-- Name: session_payment_plans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.session_payment_plans_id_seq', 1, false);


--
-- Name: session_registration_periods_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.session_registration_periods_id_seq', 1, false);


--
-- Name: sessions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sessions_id_seq', 1, false);


--
-- Name: sponsorship_percentages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sponsorship_percentages_id_seq', 1, false);


--
-- Name: student_categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_categories_id_seq', 1, false);


--
-- Name: student_comments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_comments_id_seq', 1, false);


--
-- Name: student_course_enrolments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_course_enrolments_id_seq', 1, false);


--
-- Name: student_files_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_files_id_seq', 1, false);


--
-- Name: student_guardian_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_guardian_id_seq', 1, false);


--
-- Name: student_location_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_location_id_seq', 1, false);


--
-- Name: student_offences_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_offences_id_seq', 1, false);


--
-- Name: student_offences_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_offences_id_seq1', 1, false);


--
-- Name: student_previous_institution_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_previous_institution_id_seq', 1, false);


--
-- Name: student_previous_institution_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_previous_institution_id_seq1', 1, false);


--
-- Name: student_programes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_programes_id_seq', 1, false);


--
-- Name: student_references_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_references_id_seq', 1, false);


--
-- Name: student_sponsors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_sponsors_id_seq', 1, false);


--
-- Name: student_sponsors_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_sponsors_id_seq1', 1, false);


--
-- Name: student_study_records_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_study_records_id_seq', 1, false);


--
-- Name: student_study_years_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_study_years_id_seq', 1, false);


--
-- Name: student_subjects_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_subjects_id_seq', 1, false);


--
-- Name: student_subjects_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_subjects_id_seq1', 1, false);


--
-- Name: student_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.student_type_id_seq', 1, false);


--
-- Name: students_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.students_id_seq', 1, false);


--
-- Name: studies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.studies_id_seq', 1, false);


--
-- Name: study_course_loads_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.study_course_loads_id_seq', 1, false);


--
-- Name: study_majors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.study_majors_id_seq', 1, false);


--
-- Name: study_modes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.study_modes_id_seq', 1, false);


--
-- Name: study_structure_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.study_structure_id_seq', 1, false);


--
-- Name: study_year_session_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.study_year_session_types_id_seq', 1, false);


--
-- Name: study_year_sessions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.study_year_sessions_id_seq', 1, false);


--
-- Name: study_years_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.study_years_id_seq', 1, false);


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
-- Name: academic_intakes academic_intakes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_intakes
    ADD CONSTRAINT academic_intakes_pkey PRIMARY KEY (id);


--
-- Name: admission_eligibility admission_criteria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility
    ADD CONSTRAINT admission_criteria_pkey PRIMARY KEY (id);


--
-- Name: admission_eligibility_required_subjects admission_eligibility_required_subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility_required_subjects
    ADD CONSTRAINT admission_eligibility_required_subjects_pkey PRIMARY KEY (id);


--
-- Name: applicant_files applicant_files_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_files
    ADD CONSTRAINT applicant_files_pkey PRIMARY KEY (id);


--
-- Name: applicant_guardian applicant_guardian_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_guardian
    ADD CONSTRAINT applicant_guardian_pkey PRIMARY KEY (id);


--
-- Name: applicant_location applicant_location_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_location
    ADD CONSTRAINT applicant_location_pkey PRIMARY KEY (id);


--
-- Name: applicants applicant_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicants
    ADD CONSTRAINT applicant_number_unique UNIQUE (number);


--
-- Name: applicant_references applicant_references_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_references
    ADD CONSTRAINT applicant_references_pkey PRIMARY KEY (id);


--
-- Name: applicants applicants_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicants
    ADD CONSTRAINT applicants_pkey PRIMARY KEY (id);


--
-- Name: application_fee_payments application_fee_payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_fee_payments
    ADD CONSTRAINT application_fee_payments_pkey PRIMARY KEY (id);


--
-- Name: application_period_programes application_period_programes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_period_programes
    ADD CONSTRAINT application_period_programes_pkey PRIMARY KEY (id);


--
-- Name: application_periods application_periods_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_periods
    ADD CONSTRAINT application_periods_name_unique UNIQUE (name);


--
-- Name: application_periods application_periods_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_periods
    ADD CONSTRAINT application_periods_pkey PRIMARY KEY (id);


--
-- Name: audit_logs audit_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audit_logs
    ADD CONSTRAINT audit_logs_pkey PRIMARY KEY (id);


--
-- Name: campuses campus_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campuses
    ADD CONSTRAINT campus_code_unique UNIQUE (code);


--
-- Name: campuses campus_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campuses
    ADD CONSTRAINT campus_name_unique UNIQUE (name);


--
-- Name: campuses campus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campuses
    ADD CONSTRAINT campus_pkey PRIMARY KEY (id);


--
-- Name: centres centres_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.centres
    ADD CONSTRAINT centres_name_unique UNIQUE (name);


--
-- Name: centres centres_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.centres
    ADD CONSTRAINT centres_pkey PRIMARY KEY (id);


--
-- Name: schools code unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schools
    ADD CONSTRAINT "code unique" UNIQUE (number);


--
-- Name: comments comment_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comments
    ADD CONSTRAINT comment_code_unique UNIQUE (code);


--
-- Name: comments comments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comments
    ADD CONSTRAINT comments_pkey PRIMARY KEY (id);


--
-- Name: nationalities countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nationalities
    ADD CONSTRAINT countries_pkey PRIMARY KEY (id);


--
-- Name: course_groupings course_groupings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_groupings
    ADD CONSTRAINT course_groupings_pkey PRIMARY KEY (id);


--
-- Name: course_staff course_staff_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_staff
    ADD CONSTRAINT course_staff_pkey PRIMARY KEY (id);


--
-- Name: courses courses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_pkey PRIMARY KEY (id);


--
-- Name: courses courses_unique_code; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_unique_code UNIQUE (code);


--
-- Name: departments departments_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_code_unique UNIQUE (code);


--
-- Name: departments departments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_pkey PRIMARY KEY (id);


--
-- Name: disabilities disabilities_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disabilities
    ADD CONSTRAINT disabilities_name_unique UNIQUE (name);


--
-- Name: disabilities disabilities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disabilities
    ADD CONSTRAINT disabilities_pkey PRIMARY KEY (id);


--
-- Name: districts districts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.districts
    ADD CONSTRAINT districts_pkey PRIMARY KEY (id);


--
-- Name: aauth_users email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT email_unique UNIQUE (email) INCLUDE (email);


--
-- Name: examination_structure_components examination_structure_component_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_components
    ADD CONSTRAINT examination_structure_component_pkey PRIMARY KEY (id);


--
-- Name: examination_structure_component_types examination_structure_component_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_component_types
    ADD CONSTRAINT examination_structure_component_types_pkey PRIMARY KEY (id);


--
-- Name: examination_structure_component_types examination_structure_component_types_unique_name; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_component_types
    ADD CONSTRAINT examination_structure_component_types_unique_name UNIQUE (name);


--
-- Name: examination_structure_components examination_structure_component_unique_name; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_components
    ADD CONSTRAINT examination_structure_component_unique_name UNIQUE (name);


--
-- Name: examination_structures examination_structure_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structures
    ADD CONSTRAINT examination_structure_pkey PRIMARY KEY (id);


--
-- Name: fee_categories fee_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fee_categories
    ADD CONSTRAINT fee_categories_pkey PRIMARY KEY (id);


--
-- Name: fee_categories fee_category_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fee_categories
    ADD CONSTRAINT fee_category_code_unique UNIQUE (code);


--
-- Name: fee_types fee_type_unique_code; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fee_types
    ADD CONSTRAINT fee_type_unique_code UNIQUE (code);


--
-- Name: fee_types fee_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fee_types
    ADD CONSTRAINT fee_types_pkey PRIMARY KEY (id);


--
-- Name: grading_system_grades grading_system_grades_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_system_grades
    ADD CONSTRAINT grading_system_grades_pkey PRIMARY KEY (id);


--
-- Name: grading_systems grading_system_unique_name; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_systems
    ADD CONSTRAINT grading_system_unique_name UNIQUE (name);


--
-- Name: grading_systems grading_systems_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_systems
    ADD CONSTRAINT grading_systems_pkey PRIMARY KEY (id);


--
-- Name: hostel_blocks hostel_blocks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostel_blocks
    ADD CONSTRAINT hostel_blocks_pkey PRIMARY KEY (id);


--
-- Name: hostels hostels_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostels
    ADD CONSTRAINT hostels_code_unique UNIQUE (code);


--
-- Name: hostels hostels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostels
    ADD CONSTRAINT hostels_pkey PRIMARY KEY (id);


--
-- Name: aauth_users man_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT man_number_unique UNIQUE (man_number);


--
-- Name: schools name unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schools
    ADD CONSTRAINT "name unique" UNIQUE (name);


--
-- Name: districts name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.districts
    ADD CONSTRAINT name_unique UNIQUE (name);


--
-- Name: national_groupings national_groupings_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.national_groupings
    ADD CONSTRAINT national_groupings_code_unique UNIQUE (code);


--
-- Name: national_groupings national_groupings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.national_groupings
    ADD CONSTRAINT national_groupings_pkey PRIMARY KEY (id);


--
-- Name: nationalities nationality_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nationalities
    ADD CONSTRAINT nationality_code_unique UNIQUE (iso_code);


--
-- Name: nationalities nationality_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nationalities
    ADD CONSTRAINT nationality_name_unique UNIQUE (name);


--
-- Name: students number_student_uniqueness; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT number_student_uniqueness PRIMARY KEY (number);


--
-- Name: study_paths path_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_paths
    ADD CONSTRAINT path_pkey PRIMARY KEY (id);


--
-- Name: study_paths paths_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_paths
    ADD CONSTRAINT paths_code_unique UNIQUE (code);


--
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- Name: program_classes program_class_unique_name; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.program_classes
    ADD CONSTRAINT program_class_unique_name UNIQUE (name);


--
-- Name: program_classes program_classes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.program_classes
    ADD CONSTRAINT program_classes_pkey PRIMARY KEY (id);


--
-- Name: programs program_unique_code; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.programs
    ADD CONSTRAINT program_unique_code UNIQUE (code);


--
-- Name: programs programs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.programs
    ADD CONSTRAINT programs_pkey PRIMARY KEY (id);


--
-- Name: provinces province_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provinces
    ADD CONSTRAINT province_name_unique UNIQUE (name);


--
-- Name: provinces province_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provinces
    ADD CONSTRAINT province_pkey PRIMARY KEY (id);


--
-- Name: room_properties room_properties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_properties
    ADD CONSTRAINT room_properties_pkey PRIMARY KEY (id);


--
-- Name: room_property_types room_property_types_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_property_types
    ADD CONSTRAINT room_property_types_name_unique UNIQUE (name);


--
-- Name: room_property_types room_property_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_property_types
    ADD CONSTRAINT room_property_types_pkey PRIMARY KEY (id);


--
-- Name: room_types room_types_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_types
    ADD CONSTRAINT room_types_name_unique UNIQUE (name);


--
-- Name: room_types room_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_types
    ADD CONSTRAINT room_types_pkey PRIMARY KEY (id);


--
-- Name: rooms rooms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT rooms_pkey PRIMARY KEY (id);


--
-- Name: schools school_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schools
    ADD CONSTRAINT school_pkey PRIMARY KEY (id);


--
-- Name: secondary_school_subjects school_subject_unique_name; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_school_subjects
    ADD CONSTRAINT school_subject_unique_name UNIQUE (name);


--
-- Name: secondary_schools sec_school_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_schools
    ADD CONSTRAINT sec_school_code_unique UNIQUE (code);


--
-- Name: secondary_school_subjects secondary_school_subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_school_subjects
    ADD CONSTRAINT secondary_school_subjects_pkey PRIMARY KEY (id);


--
-- Name: secondary_schools secondary_schools_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_schools
    ADD CONSTRAINT secondary_schools_pkey PRIMARY KEY (id);


--
-- Name: academic_sessions session_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_sessions
    ADD CONSTRAINT session_code_unique UNIQUE (code, name);


--
-- Name: student_session_invoices session_fees_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_session_invoices
    ADD CONSTRAINT session_fees_pkey PRIMARY KEY (id);


--
-- Name: session_minimum_tuition_payments session_minimum_tuition_payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_minimum_tuition_payments
    ADD CONSTRAINT session_minimum_tuition_payments_pkey PRIMARY KEY (id);


--
-- Name: session_payment_plans session_payment_plans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_payment_plans
    ADD CONSTRAINT session_payment_plans_pkey PRIMARY KEY (id);


--
-- Name: session_registration_periods session_registration_periods_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_registration_periods
    ADD CONSTRAINT session_registration_periods_pkey PRIMARY KEY (id);


--
-- Name: academic_sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: sponsorship_percentages sponsorship_percentages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsorship_percentages
    ADD CONSTRAINT sponsorship_percentages_pkey PRIMARY KEY (id);


--
-- Name: student_categories student_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_categories
    ADD CONSTRAINT student_categories_pkey PRIMARY KEY (id);


--
-- Name: student_comments student_comments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_comments
    ADD CONSTRAINT student_comments_pkey PRIMARY KEY (id);


--
-- Name: student_course_enrolments student_course_enrolments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_course_enrolments
    ADD CONSTRAINT student_course_enrolments_pkey PRIMARY KEY (id);


--
-- Name: student_files student_files_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_files
    ADD CONSTRAINT student_files_pkey PRIMARY KEY (id);


--
-- Name: student_guardian student_guardian_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_guardian
    ADD CONSTRAINT student_guardian_pkey PRIMARY KEY (id);


--
-- Name: student_location student_location_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_location
    ADD CONSTRAINT student_location_pkey PRIMARY KEY (id);


--
-- Name: offences student_offences_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.offences
    ADD CONSTRAINT student_offences_pkey PRIMARY KEY (id);


--
-- Name: student_offences student_offences_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_offences
    ADD CONSTRAINT student_offences_pkey1 PRIMARY KEY (id);


--
-- Name: offences student_offences_unique_name; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.offences
    ADD CONSTRAINT student_offences_unique_name UNIQUE (name);


--
-- Name: applicant_previous_institution student_previous_institution_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_previous_institution
    ADD CONSTRAINT student_previous_institution_pkey PRIMARY KEY (id);


--
-- Name: student_previous_institution student_previous_institution_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_previous_institution
    ADD CONSTRAINT student_previous_institution_pkey1 PRIMARY KEY (id);


--
-- Name: student_programes student_programes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_programes
    ADD CONSTRAINT student_programes_pkey PRIMARY KEY (id);


--
-- Name: student_references student_references_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_references
    ADD CONSTRAINT student_references_pkey PRIMARY KEY (id);


--
-- Name: student_registrations student_registrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_registrations
    ADD CONSTRAINT student_registrations_pkey PRIMARY KEY (id);


--
-- Name: sponsors student_sponsors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsors
    ADD CONSTRAINT student_sponsors_pkey PRIMARY KEY (id);


--
-- Name: student_sponsors student_sponsors_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_sponsors
    ADD CONSTRAINT student_sponsors_pkey1 PRIMARY KEY (id);


--
-- Name: sponsors student_sponsors_unique_name; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsors
    ADD CONSTRAINT student_sponsors_unique_name UNIQUE (name);


--
-- Name: student_study_records student_study_records_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_records
    ADD CONSTRAINT student_study_records_pkey PRIMARY KEY (id);


--
-- Name: student_study_records student_study_records_student_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_records
    ADD CONSTRAINT student_study_records_student_unique UNIQUE (student);


--
-- Name: student_study_years student_study_years_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_years
    ADD CONSTRAINT student_study_years_pkey PRIMARY KEY (id);


--
-- Name: applicant_subjects student_subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_subjects
    ADD CONSTRAINT student_subjects_pkey PRIMARY KEY (id);


--
-- Name: student_subjects student_subjects_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_subjects
    ADD CONSTRAINT student_subjects_pkey1 PRIMARY KEY (id);


--
-- Name: student_type student_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_type
    ADD CONSTRAINT student_type_pkey PRIMARY KEY (id);


--
-- Name: studies studies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.studies
    ADD CONSTRAINT studies_pkey PRIMARY KEY (id);


--
-- Name: study_course_loads study_course_loads_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_course_loads
    ADD CONSTRAINT study_course_loads_pkey PRIMARY KEY (id);


--
-- Name: study_majors study_majors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_majors
    ADD CONSTRAINT study_majors_pkey PRIMARY KEY (id);


--
-- Name: study_modes study_mode_unique_name; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_modes
    ADD CONSTRAINT study_mode_unique_name UNIQUE (name);


--
-- Name: study_modes study_modes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_modes
    ADD CONSTRAINT study_modes_pkey PRIMARY KEY (id);


--
-- Name: study_structures study_structure_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_structures
    ADD CONSTRAINT study_structure_pkey PRIMARY KEY (id);


--
-- Name: study_year_session_types study_year_session_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_year_session_types
    ADD CONSTRAINT study_year_session_types_pkey PRIMARY KEY (id);


--
-- Name: study_year_sessions study_year_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_year_sessions
    ADD CONSTRAINT study_year_sessions_pkey PRIMARY KEY (id);


--
-- Name: study_years study_years_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_years
    ADD CONSTRAINT study_years_pkey PRIMARY KEY (id);


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
-- Name: aauth_users aauth_users_departmentsfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT aauth_users_departmentsfk FOREIGN KEY (department) REFERENCES public.departments(id) NOT VALID;


--
-- Name: aauth_users aauth_users_group_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT aauth_users_group_fk FOREIGN KEY ("group") REFERENCES public.aauth_groups(id);


--
-- Name: admission_eligibility admission_criteria_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility
    ADD CONSTRAINT admission_criteria_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: admission_eligibility admission_criteria_intake_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility
    ADD CONSTRAINT admission_criteria_intake_fk FOREIGN KEY (intake) REFERENCES public.academic_intakes(id);


--
-- Name: admission_eligibility admission_criteria_programe_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility
    ADD CONSTRAINT admission_criteria_programe_fk FOREIGN KEY (program) REFERENCES public.programs(id);


--
-- Name: admission_eligibility admission_criteria_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility
    ADD CONSTRAINT admission_criteria_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: admission_eligibility_required_subjects admission_eligibility_required_sub_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility_required_subjects
    ADD CONSTRAINT admission_eligibility_required_sub_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: admission_eligibility_required_subjects admission_eligibility_required_sub_intake_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility_required_subjects
    ADD CONSTRAINT admission_eligibility_required_sub_intake_fk FOREIGN KEY (intake) REFERENCES public.academic_intakes(id);


--
-- Name: admission_eligibility_required_subjects admission_eligibility_required_sub_program_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility_required_subjects
    ADD CONSTRAINT admission_eligibility_required_sub_program_fk FOREIGN KEY (program) REFERENCES public.programs(id);


--
-- Name: admission_eligibility_required_subjects admission_eligibility_required_sub_subject_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility_required_subjects
    ADD CONSTRAINT admission_eligibility_required_sub_subject_fk FOREIGN KEY (subject) REFERENCES public.secondary_school_subjects(id);


--
-- Name: admission_eligibility_required_subjects admission_eligibility_required_sub_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admission_eligibility_required_subjects
    ADD CONSTRAINT admission_eligibility_required_sub_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: applicant_guardian applcant_guardian_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_guardian
    ADD CONSTRAINT applcant_guardian_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: applicant_guardian applcant_guardian_district_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_guardian
    ADD CONSTRAINT applcant_guardian_district_fk FOREIGN KEY (district) REFERENCES public.districts(id);


--
-- Name: applicants applicant_center_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicants
    ADD CONSTRAINT applicant_center_fk FOREIGN KEY (center) REFERENCES public.centres(id) NOT VALID;


--
-- Name: applicants applicant_disability_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicants
    ADD CONSTRAINT applicant_disability_fk FOREIGN KEY (disability) REFERENCES public.disabilities(id) NOT VALID;


--
-- Name: applicant_files applicant_files_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_files
    ADD CONSTRAINT applicant_files_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: applicant_location applicant_location_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_location
    ADD CONSTRAINT applicant_location_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: applicant_location applicant_location_district_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_location
    ADD CONSTRAINT applicant_location_district_fk FOREIGN KEY (district) REFERENCES public.districts(id);


--
-- Name: applicants applicant_nationality_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicants
    ADD CONSTRAINT applicant_nationality_fk FOREIGN KEY (nationality) REFERENCES public.nationalities(id) NOT VALID;


--
-- Name: applicants applicant_period_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicants
    ADD CONSTRAINT applicant_period_fk FOREIGN KEY (application_period) REFERENCES public.application_periods(id) NOT VALID;


--
-- Name: applicant_previous_institution applicant_previous_institution_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_previous_institution
    ADD CONSTRAINT applicant_previous_institution_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: applicant_programs applicant_programs_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_programs
    ADD CONSTRAINT applicant_programs_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: applicant_programs applicant_programs_program_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_programs
    ADD CONSTRAINT applicant_programs_program_fk FOREIGN KEY (program) REFERENCES public.programs(id);


--
-- Name: applicant_references applicant_references_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_references
    ADD CONSTRAINT applicant_references_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: applicants applicant_secondary_school_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicants
    ADD CONSTRAINT applicant_secondary_school_fk FOREIGN KEY (secondary_school) REFERENCES public.secondary_schools(id) NOT VALID;


--
-- Name: applicant_subjects applicant_subjects_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_subjects
    ADD CONSTRAINT applicant_subjects_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: applicant_subjects applicant_subjects_subject_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.applicant_subjects
    ADD CONSTRAINT applicant_subjects_subject_fk FOREIGN KEY (subject) REFERENCES public.secondary_school_subjects(id);


--
-- Name: application_fee_payments applicantion_fee_payments_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_fee_payments
    ADD CONSTRAINT applicantion_fee_payments_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: application_fee_payments applicantion_fee_payments_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_fee_payments
    ADD CONSTRAINT applicantion_fee_payments_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: application_fee_payments applicantion_fee_payments_updateby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_fee_payments
    ADD CONSTRAINT applicantion_fee_payments_updateby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: application_fees application_fees_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_fees
    ADD CONSTRAINT application_fees_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: application_fees application_fees_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_fees
    ADD CONSTRAINT application_fees_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: application_period_programes application_period_programes_ap_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_period_programes
    ADD CONSTRAINT application_period_programes_ap_fk FOREIGN KEY (application_period_id) REFERENCES public.application_periods(id) NOT VALID;


--
-- Name: application_period_programes application_period_programes_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_period_programes
    ADD CONSTRAINT application_period_programes_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: application_period_programes application_period_programes_programe_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_period_programes
    ADD CONSTRAINT application_period_programes_programe_fk FOREIGN KEY (program) REFERENCES public.programs(id) NOT VALID;


--
-- Name: application_period_programes application_period_programes_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_period_programes
    ADD CONSTRAINT application_period_programes_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: application_periods application_periods_created_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_periods
    ADD CONSTRAINT application_periods_created_by_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: application_periods application_periods_intake_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_periods
    ADD CONSTRAINT application_periods_intake_fk FOREIGN KEY (intake) REFERENCES public.academic_intakes(id);


--
-- Name: application_periods application_periods_updated_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.application_periods
    ADD CONSTRAINT application_periods_updated_by_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: campuses campus_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campuses
    ADD CONSTRAINT campus_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: campuses campus_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campuses
    ADD CONSTRAINT campus_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: fee_categories cat_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fee_categories
    ADD CONSTRAINT cat_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: fee_categories cat_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fee_categories
    ADD CONSTRAINT cat_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: centres centres_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.centres
    ADD CONSTRAINT centres_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: centres centres_districtfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.centres
    ADD CONSTRAINT centres_districtfk FOREIGN KEY (district) REFERENCES public.districts(id) NOT VALID;


--
-- Name: centres centres_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.centres
    ADD CONSTRAINT centres_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: comments comments_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comments
    ADD CONSTRAINT comments_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: comments comments_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comments
    ADD CONSTRAINT comments_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: examination_structure_components componet_component_type_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_components
    ADD CONSTRAINT componet_component_type_fk FOREIGN KEY (component_type) REFERENCES public.examination_structure_component_types(id);


--
-- Name: examination_structure_components componet_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_components
    ADD CONSTRAINT componet_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: examination_structure_components componet_examination_structure_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_components
    ADD CONSTRAINT componet_examination_structure_fk FOREIGN KEY (examination_structure) REFERENCES public.examination_structures(id);


--
-- Name: examination_structure_components componet_updatedtedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_components
    ADD CONSTRAINT componet_updatedtedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: nationalities countries_createdbyfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nationalities
    ADD CONSTRAINT countries_createdbyfk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: nationalities countries_updatedbyfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nationalities
    ADD CONSTRAINT countries_updatedbyfk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: courses course_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT course_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_course_enrolments course_enrolment_course_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_course_enrolments
    ADD CONSTRAINT course_enrolment_course_fk FOREIGN KEY (course) REFERENCES public.courses(id) NOT VALID;


--
-- Name: student_course_enrolments course_enrolment_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_course_enrolments
    ADD CONSTRAINT course_enrolment_session_fk FOREIGN KEY (session) REFERENCES public.academic_sessions(id) NOT VALID;


--
-- Name: student_course_enrolments course_enrolment_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_course_enrolments
    ADD CONSTRAINT course_enrolment_student_fk FOREIGN KEY (student) REFERENCES public.students(number) NOT VALID;


--
-- Name: courses course_examstructure_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT course_examstructure_fk FOREIGN KEY (exam_structure) REFERENCES public.examination_structures(id);


--
-- Name: courses course_gradingsystem_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT course_gradingsystem_fk FOREIGN KEY (grading_system) REFERENCES public.grading_systems(id);


--
-- Name: course_groupings course_groupings_course_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_groupings
    ADD CONSTRAINT course_groupings_course_fk FOREIGN KEY (course) REFERENCES public.courses(id);


--
-- Name: course_groupings course_groupings_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_groupings
    ADD CONSTRAINT course_groupings_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: course_groupings course_groupings_major_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_groupings
    ADD CONSTRAINT course_groupings_major_fk FOREIGN KEY (major) REFERENCES public.study_majors(id);


--
-- Name: course_groupings course_groupings_mode_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_groupings
    ADD CONSTRAINT course_groupings_mode_fk FOREIGN KEY (study_mode) REFERENCES public.study_modes(id);


--
-- Name: course_groupings course_groupings_study_year_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_groupings
    ADD CONSTRAINT course_groupings_study_year_session_fk FOREIGN KEY (study_year_session) REFERENCES public.study_year_sessions(id);


--
-- Name: course_groupings course_groupings_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_groupings
    ADD CONSTRAINT course_groupings_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: study_course_loads course_loads_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_course_loads
    ADD CONSTRAINT course_loads_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: study_course_loads course_loads_study_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_course_loads
    ADD CONSTRAINT course_loads_study_fk FOREIGN KEY (study) REFERENCES public.studies(id);


--
-- Name: study_course_loads course_loads_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_course_loads
    ADD CONSTRAINT course_loads_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: course_staff course_staff_course_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_staff
    ADD CONSTRAINT course_staff_course_fk FOREIGN KEY (course) REFERENCES public.courses(id);


--
-- Name: course_staff course_staff_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_staff
    ADD CONSTRAINT course_staff_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: course_staff course_staff_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_staff
    ADD CONSTRAINT course_staff_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: course_staff course_staff_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.course_staff
    ADD CONSTRAINT course_staff_user_fk FOREIGN KEY ("user") REFERENCES public.aauth_users(id);


--
-- Name: courses course_study_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT course_study_fk FOREIGN KEY (study) REFERENCES public.studies(id);


--
-- Name: courses course_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT course_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: departments department_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT department_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: departments department_schoolfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT department_schoolfk FOREIGN KEY (school) REFERENCES public.schools(id);


--
-- Name: departments department_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT department_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: departments department_userfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT department_userfk FOREIGN KEY (head) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: disabilities disabilities_createdat_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disabilities
    ADD CONSTRAINT disabilities_createdat_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: disabilities disabilities_updatedat_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disabilities
    ADD CONSTRAINT disabilities_updatedat_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: districts district_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.districts
    ADD CONSTRAINT district_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: districts district_province_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.districts
    ADD CONSTRAINT district_province_fk FOREIGN KEY (province) REFERENCES public.provinces(id) NOT VALID;


--
-- Name: districts district_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.districts
    ADD CONSTRAINT district_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: examination_structure_component_types exam_structure_component_types_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_component_types
    ADD CONSTRAINT exam_structure_component_types_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: examination_structure_component_types exam_structure_component_types_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structure_component_types
    ADD CONSTRAINT exam_structure_component_types_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: examination_structures exam_structure_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structures
    ADD CONSTRAINT exam_structure_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: examination_structures exam_structure_school_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structures
    ADD CONSTRAINT exam_structure_school_fk FOREIGN KEY (school) REFERENCES public.schools(id);


--
-- Name: examination_structures exam_structure_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examination_structures
    ADD CONSTRAINT exam_structure_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: fee_types fee_type_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fee_types
    ADD CONSTRAINT fee_type_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: fee_types fee_type_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fee_types
    ADD CONSTRAINT fee_type_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: grading_systems grading_system_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_systems
    ADD CONSTRAINT grading_system_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: grading_system_grades grading_system_grades_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_system_grades
    ADD CONSTRAINT grading_system_grades_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: grading_system_grades grading_system_grades_gs_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_system_grades
    ADD CONSTRAINT grading_system_grades_gs_fk FOREIGN KEY (grading_system) REFERENCES public.grading_systems(id);


--
-- Name: grading_system_grades grading_system_grades_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_system_grades
    ADD CONSTRAINT grading_system_grades_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: grading_systems grading_system_school_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_systems
    ADD CONSTRAINT grading_system_school_fk FOREIGN KEY (school) REFERENCES public.schools(id);


--
-- Name: grading_systems grading_system_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grading_systems
    ADD CONSTRAINT grading_system_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


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
-- Name: hostel_blocks hostelblock_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostel_blocks
    ADD CONSTRAINT hostelblock_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: hostel_blocks hostelblock_hostel_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostel_blocks
    ADD CONSTRAINT hostelblock_hostel_fk FOREIGN KEY (hostel) REFERENCES public.hostels(id) NOT VALID;


--
-- Name: hostel_blocks hostelblock_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostel_blocks
    ADD CONSTRAINT hostelblock_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: hostels hostels_campus_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostels
    ADD CONSTRAINT hostels_campus_fk FOREIGN KEY (campus) REFERENCES public.campuses(id);


--
-- Name: hostels hostels_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostels
    ADD CONSTRAINT hostels_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: hostels hostels_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hostels
    ADD CONSTRAINT hostels_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: academic_intakes intake_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_intakes
    ADD CONSTRAINT intake_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: academic_intakes intake_study_structure_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_intakes
    ADD CONSTRAINT intake_study_structure_fk FOREIGN KEY (study_structure) REFERENCES public.study_structures(id);


--
-- Name: academic_intakes intake_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_intakes
    ADD CONSTRAINT intake_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: national_groupings ngroupings_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.national_groupings
    ADD CONSTRAINT ngroupings_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: national_groupings ngroupings_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.national_groupings
    ADD CONSTRAINT ngroupings_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: offences offences_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.offences
    ADD CONSTRAINT offences_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: offences offences_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.offences
    ADD CONSTRAINT offences_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: study_paths paths_created_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_paths
    ADD CONSTRAINT paths_created_by_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: study_paths paths_updated_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_paths
    ADD CONSTRAINT paths_updated_by_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: payments payments_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_session_fk FOREIGN KEY (session) REFERENCES public.academic_sessions(id);


--
-- Name: payments payments_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: payments payments_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: program_classes program_class_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.program_classes
    ADD CONSTRAINT program_class_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: program_classes program_class_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.program_classes
    ADD CONSTRAINT program_class_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: programs programs_category_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.programs
    ADD CONSTRAINT programs_category_fk FOREIGN KEY (category) REFERENCES public.fee_categories(id);


--
-- Name: programs programs_class_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.programs
    ADD CONSTRAINT programs_class_fk FOREIGN KEY (class) REFERENCES public.program_classes(id);


--
-- Name: programs programs_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.programs
    ADD CONSTRAINT programs_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: programs programs_department_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.programs
    ADD CONSTRAINT programs_department_fk FOREIGN KEY (department) REFERENCES public.departments(id) NOT VALID;


--
-- Name: programs programs_study_structure_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.programs
    ADD CONSTRAINT programs_study_structure_fk FOREIGN KEY (study_structure) REFERENCES public.study_structures(id) NOT VALID;


--
-- Name: programs programs_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.programs
    ADD CONSTRAINT programs_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: session_registration_periods registration_periods_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_registration_periods
    ADD CONSTRAINT registration_periods_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: session_registration_periods registration_periods_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_registration_periods
    ADD CONSTRAINT registration_periods_session_fk FOREIGN KEY (academic_session) REFERENCES public.academic_sessions(id);


--
-- Name: session_registration_periods registration_periods_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_registration_periods
    ADD CONSTRAINT registration_periods_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: rooms room_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT room_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: rooms room_hostleblock_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT room_hostleblock_fk FOREIGN KEY (hostel_block) REFERENCES public.hostel_blocks(id) NOT VALID;


--
-- Name: room_properties room_properties_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_properties
    ADD CONSTRAINT room_properties_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: room_properties room_properties_room_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_properties
    ADD CONSTRAINT room_properties_room_fk FOREIGN KEY (room) REFERENCES public.rooms(id);


--
-- Name: room_properties room_properties_type_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_properties
    ADD CONSTRAINT room_properties_type_fk FOREIGN KEY (type) REFERENCES public.room_property_types(id);


--
-- Name: room_properties room_properties_updatedat_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_properties
    ADD CONSTRAINT room_properties_updatedat_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: room_property_types room_property_types_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_property_types
    ADD CONSTRAINT room_property_types_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: room_property_types room_property_types_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_property_types
    ADD CONSTRAINT room_property_types_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: rooms room_type_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT room_type_fk FOREIGN KEY (type) REFERENCES public.room_types(id) NOT VALID;


--
-- Name: room_types room_types_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_types
    ADD CONSTRAINT room_types_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: room_types room_types_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.room_types
    ADD CONSTRAINT room_types_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: rooms room_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rooms
    ADD CONSTRAINT room_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: schools school_campus_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schools
    ADD CONSTRAINT school_campus_fk FOREIGN KEY (campus) REFERENCES public.campuses(id);


--
-- Name: schools school_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schools
    ADD CONSTRAINT school_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: secondary_school_subjects school_subject_created_by; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_school_subjects
    ADD CONSTRAINT school_subject_created_by FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: secondary_school_subjects school_subject_updated_by; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_school_subjects
    ADD CONSTRAINT school_subject_updated_by FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: schools school_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.schools
    ADD CONSTRAINT school_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: secondary_schools secschools_createdbyfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_schools
    ADD CONSTRAINT secschools_createdbyfk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: secondary_schools secschools_districtfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_schools
    ADD CONSTRAINT secschools_districtfk FOREIGN KEY (district) REFERENCES public.districts(id) NOT VALID;


--
-- Name: secondary_schools secschools_updatedbyfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.secondary_schools
    ADD CONSTRAINT secschools_updatedbyfk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: student_session_invoices session_fees_fee_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_session_invoices
    ADD CONSTRAINT session_fees_fee_fk FOREIGN KEY (fee) REFERENCES public.fee_types(id);


--
-- Name: student_session_invoices session_fees_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_session_invoices
    ADD CONSTRAINT session_fees_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_session_invoices session_fees_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_session_invoices
    ADD CONSTRAINT session_fees_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: session_minimum_tuition_payments session_min_payments_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_minimum_tuition_payments
    ADD CONSTRAINT session_min_payments_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: session_minimum_tuition_payments session_min_payments_prclass_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_minimum_tuition_payments
    ADD CONSTRAINT session_min_payments_prclass_fk FOREIGN KEY (programe_class) REFERENCES public.program_classes(id);


--
-- Name: session_minimum_tuition_payments session_min_payments_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_minimum_tuition_payments
    ADD CONSTRAINT session_min_payments_session_fk FOREIGN KEY (session) REFERENCES public.academic_sessions(id);


--
-- Name: session_minimum_tuition_payments session_min_payments_studcat_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_minimum_tuition_payments
    ADD CONSTRAINT session_min_payments_studcat_fk FOREIGN KEY (student_category) REFERENCES public.student_categories(id);


--
-- Name: session_minimum_tuition_payments session_min_payments_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_minimum_tuition_payments
    ADD CONSTRAINT session_min_payments_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: session_payment_plans session_payment_plans_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_payment_plans
    ADD CONSTRAINT session_payment_plans_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: session_payment_plans session_payment_plans_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_payment_plans
    ADD CONSTRAINT session_payment_plans_session_fk FOREIGN KEY (session) REFERENCES public.academic_sessions(id);


--
-- Name: session_payment_plans session_payment_plans_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.session_payment_plans
    ADD CONSTRAINT session_payment_plans_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: academic_sessions sessions_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_sessions
    ADD CONSTRAINT sessions_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: academic_sessions sessions_intake_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_sessions
    ADD CONSTRAINT sessions_intake_fk FOREIGN KEY (intake) REFERENCES public.academic_intakes(id) NOT VALID;


--
-- Name: academic_sessions sessions_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.academic_sessions
    ADD CONSTRAINT sessions_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: sponsorship_percentages sponsorship_percentages_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsorship_percentages
    ADD CONSTRAINT sponsorship_percentages_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: sponsorship_percentages sponsorship_percentages_fee_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsorship_percentages
    ADD CONSTRAINT sponsorship_percentages_fee_fk FOREIGN KEY (fee) REFERENCES public.fee_types(id);


--
-- Name: sponsorship_percentages sponsorship_percentages_sponsor_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsorship_percentages
    ADD CONSTRAINT sponsorship_percentages_sponsor_fk FOREIGN KEY (sponsor) REFERENCES public.sponsors(id);


--
-- Name: sponsorship_percentages sponsorship_percentages_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsorship_percentages
    ADD CONSTRAINT sponsorship_percentages_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: students student_applicant_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_applicant_fk FOREIGN KEY (applicant) REFERENCES public.applicants(id);


--
-- Name: students student_category_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_category_fk FOREIGN KEY (category) REFERENCES public.student_categories(id);


--
-- Name: students student_center_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_center_fk FOREIGN KEY (center) REFERENCES public.centres(id);


--
-- Name: student_comments student_comments_comment_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_comments
    ADD CONSTRAINT student_comments_comment_fk FOREIGN KEY (comment) REFERENCES public.comments(id);


--
-- Name: student_comments student_comments_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_comments
    ADD CONSTRAINT student_comments_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_comments student_comments_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_comments
    ADD CONSTRAINT student_comments_session_fk FOREIGN KEY (session) REFERENCES public.academic_sessions(id);


--
-- Name: student_comments student_comments_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_comments
    ADD CONSTRAINT student_comments_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_comments student_comments_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_comments
    ADD CONSTRAINT student_comments_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: students student_created_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_created_by_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: students student_disability_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_disability_fk FOREIGN KEY (disability) REFERENCES public.disabilities(id);


--
-- Name: student_files student_files_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_files
    ADD CONSTRAINT student_files_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_files student_files_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_files
    ADD CONSTRAINT student_files_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_files student_files_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_files
    ADD CONSTRAINT student_files_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: student_guardian student_guardian_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_guardian
    ADD CONSTRAINT student_guardian_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_guardian student_guardian_district_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_guardian
    ADD CONSTRAINT student_guardian_district_fk FOREIGN KEY (district) REFERENCES public.districts(id);


--
-- Name: student_guardian student_guardian_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_guardian
    ADD CONSTRAINT student_guardian_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_guardian student_guardian_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_guardian
    ADD CONSTRAINT student_guardian_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: student_location student_location_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_location
    ADD CONSTRAINT student_location_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_location student_location_district_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_location
    ADD CONSTRAINT student_location_district_fk FOREIGN KEY (district) REFERENCES public.districts(id);


--
-- Name: student_location student_location_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_location
    ADD CONSTRAINT student_location_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_location student_location_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_location
    ADD CONSTRAINT student_location_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: students student_nationality_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_nationality_fk FOREIGN KEY (nationality) REFERENCES public.nationalities(id);


--
-- Name: student_offences student_offences_clearedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_offences
    ADD CONSTRAINT student_offences_clearedby_fk FOREIGN KEY (cleared_by) REFERENCES public.aauth_users(id);


--
-- Name: student_offences student_offences_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_offences
    ADD CONSTRAINT student_offences_createdby_fk FOREIGN KEY (cleared_by) REFERENCES public.aauth_users(id);


--
-- Name: student_offences student_offences_offence_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_offences
    ADD CONSTRAINT student_offences_offence_fk FOREIGN KEY (offence) REFERENCES public.offences(id);


--
-- Name: student_offences student_offences_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_offences
    ADD CONSTRAINT student_offences_session_fk FOREIGN KEY (session) REFERENCES public.academic_sessions(id);


--
-- Name: student_offences student_offences_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_offences
    ADD CONSTRAINT student_offences_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_offences student_offences_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_offences
    ADD CONSTRAINT student_offences_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: student_previous_institution student_previous_institution_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_previous_institution
    ADD CONSTRAINT student_previous_institution_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_previous_institution student_previous_institution_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_previous_institution
    ADD CONSTRAINT student_previous_institution_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_previous_institution student_previous_institution_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_previous_institution
    ADD CONSTRAINT student_previous_institution_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: student_programes student_programs_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_programes
    ADD CONSTRAINT student_programs_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_programes student_programs_programe_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_programes
    ADD CONSTRAINT student_programs_programe_fk FOREIGN KEY (program) REFERENCES public.programs(id);


--
-- Name: student_programes student_programs_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_programes
    ADD CONSTRAINT student_programs_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_programes student_programs_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_programes
    ADD CONSTRAINT student_programs_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: student_references student_references_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_references
    ADD CONSTRAINT student_references_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_references student_references_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_references
    ADD CONSTRAINT student_references_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_references student_references_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_references
    ADD CONSTRAINT student_references_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: student_registrations student_registrations_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_registrations
    ADD CONSTRAINT student_registrations_session_fk FOREIGN KEY (session) REFERENCES public.academic_sessions(id);


--
-- Name: student_registrations student_registrations_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_registrations
    ADD CONSTRAINT student_registrations_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: students student_secondary_school_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_secondary_school_fk FOREIGN KEY (secondary_school) REFERENCES public.secondary_schools(id);


--
-- Name: sponsors student_sponsors_created_by; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsors
    ADD CONSTRAINT student_sponsors_created_by FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_sponsors student_sponsors_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_sponsors
    ADD CONSTRAINT student_sponsors_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_sponsors student_sponsors_sponsor_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_sponsors
    ADD CONSTRAINT student_sponsors_sponsor_fk FOREIGN KEY (sponsor) REFERENCES public.sponsors(id);


--
-- Name: student_sponsors student_sponsors_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_sponsors
    ADD CONSTRAINT student_sponsors_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: sponsors student_sponsors_updated_by; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sponsors
    ADD CONSTRAINT student_sponsors_updated_by FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: student_sponsors student_sponsors_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_sponsors
    ADD CONSTRAINT student_sponsors_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: students student_staff_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_staff_fk FOREIGN KEY (staff) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: student_study_records student_study_records_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_records
    ADD CONSTRAINT student_study_records_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_study_records student_study_records_intake_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_records
    ADD CONSTRAINT student_study_records_intake_fk FOREIGN KEY (intake) REFERENCES public.academic_intakes(id);


--
-- Name: student_study_records student_study_records_program_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_records
    ADD CONSTRAINT student_study_records_program_fk FOREIGN KEY (program) REFERENCES public.programs(id);


--
-- Name: student_study_records student_study_records_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_records
    ADD CONSTRAINT student_study_records_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_study_records student_study_records_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_records
    ADD CONSTRAINT student_study_records_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: student_study_years student_study_years_session_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_years
    ADD CONSTRAINT student_study_years_session_fk FOREIGN KEY (session) REFERENCES public.academic_sessions(id);


--
-- Name: student_study_years student_study_years_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_years
    ADD CONSTRAINT student_study_years_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_study_years student_study_years_studyyear_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_study_years
    ADD CONSTRAINT student_study_years_studyyear_fk FOREIGN KEY (study_year) REFERENCES public.study_years(id) NOT VALID;


--
-- Name: student_subjects student_subjects_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_subjects
    ADD CONSTRAINT student_subjects_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: student_subjects student_subjects_student_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_subjects
    ADD CONSTRAINT student_subjects_student_fk FOREIGN KEY (student) REFERENCES public.students(number);


--
-- Name: student_subjects student_subjects_subject_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_subjects
    ADD CONSTRAINT student_subjects_subject_fk FOREIGN KEY (subject) REFERENCES public.secondary_school_subjects(id);


--
-- Name: student_subjects student_subjects_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.student_subjects
    ADD CONSTRAINT student_subjects_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: students student_type_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_type_fk FOREIGN KEY (type) REFERENCES public.student_type(id) NOT VALID;


--
-- Name: students student_updated_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT student_updated_by_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: studies studies_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.studies
    ADD CONSTRAINT studies_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: studies studies_program_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.studies
    ADD CONSTRAINT studies_program_fk FOREIGN KEY (program) REFERENCES public.programs(id) NOT VALID;


--
-- Name: studies studies_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.studies
    ADD CONSTRAINT studies_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: study_majors study_major_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_majors
    ADD CONSTRAINT study_major_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: study_majors study_major_minor_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_majors
    ADD CONSTRAINT study_major_minor_fk FOREIGN KEY (minor) REFERENCES public.studies(id);


--
-- Name: study_majors study_major_study_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_majors
    ADD CONSTRAINT study_major_study_fk FOREIGN KEY (study) REFERENCES public.studies(id);


--
-- Name: study_majors study_major_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_majors
    ADD CONSTRAINT study_major_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: study_modes study_mode_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_modes
    ADD CONSTRAINT study_mode_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: study_modes study_mode_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_modes
    ADD CONSTRAINT study_mode_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: study_structures study_structure_created_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_structures
    ADD CONSTRAINT study_structure_created_by_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: study_structures study_structure_study_path_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_structures
    ADD CONSTRAINT study_structure_study_path_fk FOREIGN KEY (study_path) REFERENCES public.study_paths(id) NOT VALID;


--
-- Name: study_structures study_structure_updated_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_structures
    ADD CONSTRAINT study_structure_updated_by_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: study_years study_year_created_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_years
    ADD CONSTRAINT study_year_created_by_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: study_year_session_types study_year_session_types_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_year_session_types
    ADD CONSTRAINT study_year_session_types_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: study_year_session_types study_year_session_types_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_year_session_types
    ADD CONSTRAINT study_year_session_types_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- Name: study_year_sessions study_year_sessions_created_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_year_sessions
    ADD CONSTRAINT study_year_sessions_created_by_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- Name: study_year_sessions study_year_sessions_studyyear_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_year_sessions
    ADD CONSTRAINT study_year_sessions_studyyear_fk FOREIGN KEY (study_year) REFERENCES public.study_years(id);


--
-- Name: study_year_sessions study_year_sessions_type_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_year_sessions
    ADD CONSTRAINT study_year_sessions_type_fk FOREIGN KEY (type) REFERENCES public.study_year_session_types(id);


--
-- Name: study_year_sessions study_year_sessions_updated_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_year_sessions
    ADD CONSTRAINT study_year_sessions_updated_by_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- Name: study_years study_year_structure_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_years
    ADD CONSTRAINT study_year_structure_fk FOREIGN KEY (study_structure) REFERENCES public.study_structures(id);


--
-- Name: study_years study_year_updated_by_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.study_years
    ADD CONSTRAINT study_year_updated_by_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- PostgreSQL database dump complete
--

