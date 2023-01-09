--
-- PostgreSQL database dump
--

-- Dumped from database version 13.6 (Ubuntu 13.6-0ubuntu0.21.10.1)
-- Dumped by pg_dump version 13.6 (Ubuntu 13.6-0ubuntu0.21.10.1)

-- Started on 2023-01-10 00:35:18 CAT

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
-- TOC entry 675 (class 1247 OID 194922)
-- Name: gender_enum; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.gender_enum AS ENUM (
    'Male',
    'Female'
);


ALTER TYPE public.gender_enum OWNER TO postgres;

--
-- TOC entry 678 (class 1247 OID 194928)
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
-- TOC entry 208 (class 1259 OID 194933)
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
-- TOC entry 209 (class 1259 OID 194939)
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
-- TOC entry 210 (class 1259 OID 194941)
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
-- TOC entry 211 (class 1259 OID 194944)
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
-- TOC entry 212 (class 1259 OID 194946)
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
-- TOC entry 213 (class 1259 OID 194950)
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
-- TOC entry 214 (class 1259 OID 194952)
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
-- TOC entry 215 (class 1259 OID 194958)
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
-- TOC entry 216 (class 1259 OID 194960)
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
-- TOC entry 217 (class 1259 OID 194966)
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
-- TOC entry 218 (class 1259 OID 194968)
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
-- TOC entry 219 (class 1259 OID 194972)
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
-- TOC entry 220 (class 1259 OID 194974)
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
-- TOC entry 3221 (class 0 OID 0)
-- Dependencies: 220
-- Name: COLUMN aauth_users.username; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.aauth_users.username IS 'By default, man nos are the usernames';


--
-- TOC entry 221 (class 1259 OID 194984)
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
-- TOC entry 222 (class 1259 OID 195013)
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
-- TOC entry 223 (class 1259 OID 195019)
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
-- TOC entry 225 (class 1259 OID 195459)
-- Name: available_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.available_attributes (
    id bigint NOT NULL,
    attribute character varying NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.available_attributes OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 195457)
-- Name: available_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.available_attributes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.available_attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 205 (class 1259 OID 182146)
-- Name: citizen_identities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.citizen_identities (
    id bigint NOT NULL,
    nrc character varying(45) NOT NULL,
    surname character varying NOT NULL,
    given_name character varying NOT NULL,
    maiden_name character varying,
    other_name character varying,
    title character varying(15),
    gender character varying(15) NOT NULL,
    residental_address text,
    postal_address character varying,
    nationality character varying NOT NULL,
    other_nationality character varying,
    chief character varying NOT NULL,
    chiefs_provice character varying NOT NULL,
    chiefs_district character varying NOT NULL,
    date_of_birth date NOT NULL,
    country_of_birth character varying,
    town_of_birth character varying NOT NULL,
    village_of_birth character varying,
    place_of_birth_abroad character varying,
    tribe character varying NOT NULL,
    eye_color character varying,
    height_in_cm double precision,
    blood_group character varying(15),
    race character varying NOT NULL,
    marital_status character varying,
    napsa character varying,
    mobile_number character varying(20),
    email character varying(255),
    occupation character varying,
    special_marks character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone
);


ALTER TABLE public.citizen_identities OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 182144)
-- Name: citizen_identities_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.citizen_identities ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.citizen_identities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 207 (class 1259 OID 192951)
-- Name: client_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.client_attributes (
    id bigint NOT NULL,
    client bigint NOT NULL,
    attribute character varying NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    created_by integer,
    updated_by integer
);


ALTER TABLE public.client_attributes OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 192949)
-- Name: client_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.client_attributes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.client_attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 203 (class 1259 OID 182133)
-- Name: client_ip_whitelist; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.client_ip_whitelist (
    id bigint NOT NULL,
    client bigint NOT NULL,
    ip character varying(25) NOT NULL,
    created_by integer,
    updated_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.client_ip_whitelist OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 182131)
-- Name: client_ip_whitelists_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.client_ip_whitelist ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.client_ip_whitelists_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 227 (class 1259 OID 195480)
-- Name: client_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.client_users (
    id bigint NOT NULL,
    client bigint NOT NULL,
    first_name character varying NOT NULL,
    last_name character varying NOT NULL,
    other_names character varying,
    email character varying(255) NOT NULL,
    password_hash character varying NOT NULL,
    auth_key character varying(45) NOT NULL,
    password_reset_token character varying(255),
    verification_token character varying,
    active integer DEFAULT 0 NOT NULL,
    username character varying NOT NULL,
    created_at integer NOT NULL,
    updated_at integer,
    created_by bigint,
    updated_by bigint
);


ALTER TABLE public.client_users OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 195478)
-- Name: client_users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.client_users ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.client_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 201 (class 1259 OID 182122)
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    id bigint NOT NULL,
    name character varying NOT NULL,
    address character varying NOT NULL,
    contact_person_first_name character varying NOT NULL,
    phone character varying(15),
    email character varying NOT NULL,
    username character varying(255) NOT NULL,
    secret_key character varying(255) NOT NULL,
    auth_key text NOT NULL,
    active integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone,
    created_by integer,
    updated_by integer,
    can_pay character varying(20) NOT NULL,
    contact_person_last_name character varying NOT NULL
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- TOC entry 3222 (class 0 OID 0)
-- Dependencies: 201
-- Name: COLUMN clients.can_pay; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.clients.can_pay IS 'Client can pay for accessing the system or not';


--
-- TOC entry 200 (class 1259 OID 182120)
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.clients ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 233 (class 1259 OID 195569)
-- Name: configurations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.configurations (
    id bigint NOT NULL,
    name character varying NOT NULL,
    value character varying NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    created_by bigint NOT NULL,
    updated_by bigint
);


ALTER TABLE public.configurations OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 195567)
-- Name: configurations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.configurations ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.configurations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 231 (class 1259 OID 195515)
-- Name: request_charges; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.request_charges (
    id bigint NOT NULL,
    charge double precision NOT NULL,
    year integer NOT NULL,
    created_at integer NOT NULL,
    created_by bigint NOT NULL,
    updated_by integer,
    updated_at bigint
);


ALTER TABLE public.request_charges OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 195513)
-- Name: request_charges_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.request_charges ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.request_charges_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 229 (class 1259 OID 195498)
-- Name: requests; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.requests (
    id bigint NOT NULL,
    client bigint NOT NULL,
    request character varying NOT NULL,
    status integer DEFAULT 200 NOT NULL,
    amount double precision NOT NULL,
    payment_status integer DEFAULT 0 NOT NULL,
    path character varying,
    source_ip character varying NOT NULL,
    source_agent character varying,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    proof_of_payment character varying(255)
);


ALTER TABLE public.requests OWNER TO postgres;

--
-- TOC entry 3223 (class 0 OID 0)
-- Dependencies: 229
-- Name: COLUMN requests.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.requests.status IS '200=Success, 201=failed';


--
-- TOC entry 3224 (class 0 OID 0)
-- Dependencies: 229
-- Name: COLUMN requests.amount; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.requests.amount IS 'Amount charged';


--
-- TOC entry 228 (class 1259 OID 195496)
-- Name: requests_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.requests ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.requests_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 3190 (class 0 OID 194933)
-- Dependencies: 208
-- Data for Name: aauth_groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_groups (id, name, description, created_at, updated_at, created_by, updated_by) FROM stdin;
4	Administrator	Administrator group	1670069030	1670670002	\N	1
\.


--
-- TOC entry 3192 (class 0 OID 194941)
-- Dependencies: 210
-- Data for Name: aauth_perm_to_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_perm_to_group (id, permission, "group", created_by, updated_by, created_at, updated_at) FROM stdin;
125	1	4	1	1	1673019402	1673019402
126	20	4	1	1	1673019402	1673019402
127	13	4	1	1	1673019402	1673019402
128	14	4	1	1	1673019402	1673019402
129	3	4	1	1	1673019402	1673019402
130	16	4	1	1	1673019402	1673019402
131	24	4	1	1	1673019402	1673019402
132	17	4	1	1	1673019402	1673019402
133	2	4	1	1	1673019402	1673019402
134	4	4	1	1	1673019402	1673019402
135	15	4	1	1	1673019402	1673019402
136	21	4	1	1	1673019402	1673019402
137	22	4	1	1	1673019402	1673019402
138	25	4	1	1	1673019402	1673019402
139	26	4	1	1	1673019402	1673019402
\.


--
-- TOC entry 3194 (class 0 OID 194946)
-- Dependencies: 212
-- Data for Name: aauth_perm_to_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_perm_to_user (id, permission, "user", active, expiry_date, created_by, created_at, updated_by, updated_at) FROM stdin;
\.


--
-- TOC entry 3196 (class 0 OID 194952)
-- Dependencies: 214
-- Data for Name: aauth_perms; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_perms (id, name, description, "group") FROM stdin;
1	Manage users	\N	MANAGE
2	View users	\N	VIEW
3	Manage groups	\N	MANAGE
4	View groups	\N	VIEW
13	Manage user to group	\N	MANAGE
14	Manage clients	\N	MANAGE
15	View clients	\N	VIEW
16	Manage client users	\N	MANAGE
17	View client users	\N	VIEW
20	Manage request charges	\N	MANAGE
21	View request charges	\N	VIEW
22	View available attributes	\N	VIEW
23	View citizen identities	\N	VIEW
24	View requests	\N	VIEW
25	Manage configurations	\N	\N
26	View configurations	\N	\N
\.


--
-- TOC entry 3198 (class 0 OID 194960)
-- Dependencies: 216
-- Data for Name: aauth_user_files; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_user_files (id, "user", name, file, created_by, created_at, updated_by, updated_at) FROM stdin;
1	1	PROFILE	_profile.jpg	1	1672337014	1	1672337014
\.


--
-- TOC entry 3200 (class 0 OID 194968)
-- Dependencies: 218
-- Data for Name: aauth_user_to_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_user_to_group (id, "user", "group", active, created_by, updated_by, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 3202 (class 0 OID 194974)
-- Dependencies: 220
-- Data for Name: aauth_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.aauth_users (id, "group", first_name, last_name, phone, email, active, auth_key, password_hash, password_reset_token, verification_token, ip_address, login_attempts, updated_by, created_by, created_at, updated_at, man_number, expiry_date, username, last_login, other_name, title, image) FROM stdin;
1	4	Francis	Chulu	\N	chulu1francis@gmail.com	1	i8KitNy41PkH21wOeFRvXoZ2lhZqeOLF	$2y$13$KyraAltzqb8mfrZzy78Ef.Ti7ONM.Cj6Jiqo0cBdJXnRCOuxSsrnq	\N	\N	\N	0	\N	\N	1670069031	1672513041	01234	2023-03-03	chulu1francis@gmail.com	\N	\N	Mr.	\N
\.


--
-- TOC entry 3204 (class 0 OID 195013)
-- Dependencies: 222
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
46	1	Updated user group:Administrator		1672336207	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
47	1	Created user group:Accreditation officer		1672336561	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
48	1	Deleted user group:Test with its associated permissions		1672336614	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
49	1	Created user group:Head of Programs		1672336639	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
50	5	Activated account by setting the password.		1672337602	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
51	5	Requested password reset		1672337845	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
52	1	Requested password reset		1672512957	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
53	1	Updated user group:Administrator		1672517019	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
54	1	Updated user group:Accreditation officer		1672517127	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
55	1	Created user group:Test		1672595572	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
56	1	Assigned user(id:5) with man number: user group:Administrator		1672850087	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
57	1	Deleted user to group assignment. User(5) man no:, group:Administrator		1672850092	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
58	1	Deleted user group:Test with its associated permissions		1672853690	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
59	1	Deleted user group:Head of Programs with its associated permissions		1672853695	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
60	1	Deleted user group:Accreditation officer with its associated permissions		1672853700	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
61	1	Updated user group:Administrator		1672853748	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
62	1	Updated user group:Administrator		1673015377	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
63	1	Updated user group:Administrator		1673019402	127.0.0.1	Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:108.0) Gecko/20100101 Firefox/108.0
\.


--
-- TOC entry 3207 (class 0 OID 195459)
-- Dependencies: 225
-- Data for Name: available_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.available_attributes (id, attribute, name) FROM stdin;
1	nrc	NRC
2	surname	Surname
3	givenName	Given name
4	maidenName	Maiden name
5	title	Title
6	gender	Gender
7	residentalAddress	Residental address
8	postalAddress	Postal address
9	nationality	Nationality
10	countryOfBirth	Country of birth
11	townOfBirth	Town of brith
12	villageOfBirth	Village of birth
13	placeOfBirthAbroad	Place of birth abroad
14	eyeColor	Eye color
15	heightInCm	Height in cm
16	bloodGroup	Blood group
17	race	Race
18	maritalStatus	Marital status
19	napsa	NAPSA SSN
20	mobileNumber	Mobile number
21	email	Email
22	specialMarks	Special marks
\.


--
-- TOC entry 3187 (class 0 OID 182146)
-- Dependencies: 205
-- Data for Name: citizen_identities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.citizen_identities (id, nrc, surname, given_name, maiden_name, other_name, title, gender, residental_address, postal_address, nationality, other_nationality, chief, chiefs_provice, chiefs_district, date_of_birth, country_of_birth, town_of_birth, village_of_birth, place_of_birth_abroad, tribe, eye_color, height_in_cm, blood_group, race, marital_status, napsa, mobile_number, email, occupation, special_marks, created_at, updated_at) FROM stdin;
1	123456	Chulu	Chishala	\N	Francis	Mr	Male	Chilenje	Postal	Zambian	\N	Mukuni	Lusaka	Lusaka	1988-01-12	Zambia	Lusaka	Lusaka	\N	English	Brown	1.5	B	Black	Married	5654545	260978981576	chulu1francis@gmail.com	\N	\N	2022-12-16 22:16:03.770961	2022-12-30 22:16:03.770961
5	18113911	Chulu	Francis Francis Francis Francis	\N	\N	Mr	M	Address address adress address address address address	Postal	ZMB	\N	Mukuni	Lusaka	Lusaka	2020-10-27	ZMB	Lusaka	Lusaka	\N	Shona	Yellow	4.2	O	Black	Married	18987878	+260978981567	francis@email.com	Occupation	None	2023-01-03 15:45:15.621	2023-01-03 15:45:15.621
6	181138102	Test	Test name	\N	\N	Mr	M	Address line	Postal address	ZMB	\N	Mwata Kazembe	Luapula	Kasama	2022-12-28	ZMB	Lusaka	Kasama	\N	Bemba	Blue	5.3	B	White	Single	1726978767	+260987898623	email@gmail.com	Occupation	 None	2023-01-03 15:46:59.814	2023-01-03 15:46:59.814
8	1234567	Upendo	Upendo	M	Loveness	Mrs	F			ZMB		Chief	Lusaka	Lusaka	2000-02-19	ZMB	Lusaka	Village		Lozi		\N		African	maritalStatus	napsa	mobileNumber	email	occupation	specialMarks	2023-01-04 14:42:43.837	2023-01-04 14:42:43.837
\.


--
-- TOC entry 3189 (class 0 OID 192951)
-- Dependencies: 207
-- Data for Name: client_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.client_attributes (id, client, attribute, created_at, updated_at, created_by, updated_by) FROM stdin;
19	9	email	2023-01-05 14:17:21.834583	2023-01-05 14:17:21.834583	1	1
20	9	gender	2023-01-05 14:17:21.871074	2023-01-05 14:17:21.871074	1	1
21	9	givenName	2023-01-05 14:17:21.874367	2023-01-05 14:17:21.874367	1	1
22	9	maritalStatus	2023-01-05 14:17:21.87766	2023-01-05 14:17:21.87766	1	1
23	9	napsa	2023-01-05 14:17:21.880976	2023-01-05 14:17:21.880976	1	1
24	9	nationality	2023-01-05 14:17:21.884089	2023-01-05 14:17:21.884089	1	1
25	9	nrc	2023-01-05 14:17:21.887239	2023-01-05 14:17:21.887239	1	1
26	9	race	2023-01-05 14:17:21.89023	2023-01-05 14:17:21.89023	1	1
27	9	surname	2023-01-05 14:17:21.893493	2023-01-05 14:17:21.893493	1	1
34	1	bloodGroup	2023-01-05 15:45:52.097669	2023-01-05 15:45:52.097669	1	1
35	1	countryOfBirth	2023-01-05 15:45:52.129917	2023-01-05 15:45:52.129917	1	1
36	1	eyeColor	2023-01-05 15:45:52.133117	2023-01-05 15:45:52.133117	1	1
37	1	gender	2023-01-05 15:45:52.136062	2023-01-05 15:45:52.136062	1	1
38	1	givenName	2023-01-05 15:45:52.139438	2023-01-05 15:45:52.139438	1	1
39	1	maritalStatus	2023-01-05 15:45:52.142666	2023-01-05 15:45:52.142666	1	1
40	1	mobileNumber	2023-01-05 15:45:52.146163	2023-01-05 15:45:52.146163	1	1
41	1	nrc	2023-01-05 15:45:52.149222	2023-01-05 15:45:52.149222	1	1
42	1	placeOfBirthAbroad	2023-01-05 15:45:52.152182	2023-01-05 15:45:52.152182	1	1
43	1	residentalAddress	2023-01-05 15:45:52.155181	2023-01-05 15:45:52.155181	1	1
44	1	specialMarks	2023-01-05 15:45:52.158099	2023-01-05 15:45:52.158099	1	1
45	1	surname	2023-01-05 15:45:52.16128	2023-01-05 15:45:52.16128	1	1
\.


--
-- TOC entry 3185 (class 0 OID 182133)
-- Dependencies: 203
-- Data for Name: client_ip_whitelist; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.client_ip_whitelist (id, client, ip, created_by, updated_by, created_at, updated_at) FROM stdin;
5	1	127.0.0.78	1	1	2023-01-07 23:15:28.323867	2023-01-08 01:26:24.887985
4	9	127.0.0.1	1	1	2023-01-05 14:16:45.305403	2023-01-08 01:50:55.477623
\.


--
-- TOC entry 3209 (class 0 OID 195480)
-- Dependencies: 227
-- Data for Name: client_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.client_users (id, client, first_name, last_name, other_names, email, password_hash, auth_key, password_reset_token, verification_token, active, username, created_at, updated_at, created_by, updated_by) FROM stdin;
6	9	Francis	Chishala	\N	francis.chulu@unza.zm	$2y$13$n510LG0nIbGK3SRcBAcQ3eUUR0W9t7TCeIKmNAjNh.0oZxRvIXDGa	Iasx9hfuRnzJtU2	\N	\N	1	francis.chulu@unza.zm	1672912937	1673003710	1	1
\.


--
-- TOC entry 3183 (class 0 OID 182122)
-- Dependencies: 201
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (id, name, address, contact_person_first_name, phone, email, username, secret_key, auth_key, active, created_at, updated_at, created_by, updated_by, can_pay, contact_person_last_name) FROM stdin;
1	BOZ	BOZ HQ, Lusaka	Francis		chulu1francis@gmail.com	23010533	$2a$10$vrGHCjKSpZ7Qb1gdUUxMj.QHHn6eEl7AcaX0UNTj0Xn1/YWZl77j6	JZ-h2b1Bkd8U5AjBTcUY	1	2021-06-13 19:09:19	2023-01-05 08:48:14.427713	\N	1	Yes	Chulu
9	NAPSA	Address number 25567/90	Francis		francis.chulu@unza.zm	23010516	$2a$10$xVJf0E9HaKj8BtD.Yl/MveTm9wdC0bO9CoItWIrSlOSFbGg.cy..G	BTQZykpm2c	1	2023-01-05 12:02:16.402383	2023-01-08 01:51:37.261229	1	1	Yes	Chishala
\.


--
-- TOC entry 3215 (class 0 OID 195569)
-- Dependencies: 233
-- Data for Name: configurations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.configurations (id, name, value, created_at, updated_at, created_by, updated_by) FROM stdin;
2	CLIENTS_CAN_SELF_REGISTER	No	2023-01-06 19:00:30.121518	2023-01-07 19:11:54.66007	1	1
1	ALLOWED_CLIENT_USERS	2	2023-01-06 14:03:00	2023-01-07 19:12:14.085522	1	1
\.


--
-- TOC entry 3213 (class 0 OID 195515)
-- Dependencies: 231
-- Data for Name: request_charges; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.request_charges (id, charge, year, created_at, created_by, updated_by, updated_at) FROM stdin;
2	5	2023	1673023141	1	1	1673023141
\.


--
-- TOC entry 3211 (class 0 OID 195498)
-- Dependencies: 229
-- Data for Name: requests; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.requests (id, client, request, status, amount, payment_status, path, source_ip, source_agent, created_at, updated_at, proof_of_payment) FROM stdin;
2	1	citizen/identity/{nrc}	200	5	0	\N	127.0.0.1	\N	2023-01-04 20:39:00	\N	\N
\.


--
-- TOC entry 3225 (class 0 OID 0)
-- Dependencies: 209
-- Name: aauth_groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_groups_id_seq', 10, true);


--
-- TOC entry 3226 (class 0 OID 0)
-- Dependencies: 211
-- Name: aauth_perm_to_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_perm_to_group_id_seq', 139, true);


--
-- TOC entry 3227 (class 0 OID 0)
-- Dependencies: 213
-- Name: aauth_perm_to_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_perm_to_user_id_seq', 5, true);


--
-- TOC entry 3228 (class 0 OID 0)
-- Dependencies: 215
-- Name: aauth_perms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_perms_id_seq', 26, true);


--
-- TOC entry 3229 (class 0 OID 0)
-- Dependencies: 217
-- Name: aauth_user_files_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_user_files_id_seq', 1, true);


--
-- TOC entry 3230 (class 0 OID 0)
-- Dependencies: 219
-- Name: aauth_user_to_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_user_to_group_id_seq', 7, true);


--
-- TOC entry 3231 (class 0 OID 0)
-- Dependencies: 221
-- Name: aauth_users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.aauth_users_id_seq', 5, true);


--
-- TOC entry 3232 (class 0 OID 0)
-- Dependencies: 223
-- Name: audit_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.audit_logs_id_seq', 63, true);


--
-- TOC entry 3233 (class 0 OID 0)
-- Dependencies: 224
-- Name: available_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.available_attributes_id_seq', 22, true);


--
-- TOC entry 3234 (class 0 OID 0)
-- Dependencies: 204
-- Name: citizen_identities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.citizen_identities_id_seq', 8, true);


--
-- TOC entry 3235 (class 0 OID 0)
-- Dependencies: 206
-- Name: client_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.client_attributes_id_seq', 45, true);


--
-- TOC entry 3236 (class 0 OID 0)
-- Dependencies: 202
-- Name: client_ip_whitelists_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.client_ip_whitelists_id_seq', 5, true);


--
-- TOC entry 3237 (class 0 OID 0)
-- Dependencies: 226
-- Name: client_users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.client_users_id_seq', 8, true);


--
-- TOC entry 3238 (class 0 OID 0)
-- Dependencies: 200
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 9, true);


--
-- TOC entry 3239 (class 0 OID 0)
-- Dependencies: 232
-- Name: configurations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.configurations_id_seq', 2, true);


--
-- TOC entry 3240 (class 0 OID 0)
-- Dependencies: 230
-- Name: request_charges_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.request_charges_id_seq', 2, true);


--
-- TOC entry 3241 (class 0 OID 0)
-- Dependencies: 228
-- Name: requests_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.requests_id_seq', 2, true);


--
-- TOC entry 2991 (class 2606 OID 195114)
-- Name: aauth_groups aauth_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_groups
    ADD CONSTRAINT aauth_groups_pkey PRIMARY KEY (id);


--
-- TOC entry 2993 (class 2606 OID 195116)
-- Name: aauth_perm_to_group aauth_perm_to_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_pkey PRIMARY KEY (id);


--
-- TOC entry 2995 (class 2606 OID 195118)
-- Name: aauth_perm_to_user aauth_perm_to_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_pkey PRIMARY KEY (id);


--
-- TOC entry 2997 (class 2606 OID 195120)
-- Name: aauth_perms aauth_perms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perms
    ADD CONSTRAINT aauth_perms_pkey PRIMARY KEY (id);


--
-- TOC entry 2999 (class 2606 OID 195122)
-- Name: aauth_user_files aauth_user_files_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_files
    ADD CONSTRAINT aauth_user_files_pkey PRIMARY KEY (id);


--
-- TOC entry 3001 (class 2606 OID 195124)
-- Name: aauth_user_to_group aauth_user_to_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_pkey PRIMARY KEY (id);


--
-- TOC entry 3003 (class 2606 OID 195126)
-- Name: aauth_users aauth_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT aauth_users_pkey PRIMARY KEY (id);


--
-- TOC entry 3009 (class 2606 OID 195136)
-- Name: audit_logs audit_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audit_logs
    ADD CONSTRAINT audit_logs_pkey PRIMARY KEY (id);


--
-- TOC entry 3011 (class 2606 OID 195466)
-- Name: available_attributes available_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.available_attributes
    ADD CONSTRAINT available_attributes_pkey PRIMARY KEY (id);


--
-- TOC entry 2987 (class 2606 OID 182154)
-- Name: citizen_identities citizen_identities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citizen_identities
    ADD CONSTRAINT citizen_identities_pkey PRIMARY KEY (id);


--
-- TOC entry 2989 (class 2606 OID 192958)
-- Name: client_attributes client_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_attributes
    ADD CONSTRAINT client_attributes_pkey PRIMARY KEY (id);


--
-- TOC entry 2985 (class 2606 OID 182138)
-- Name: client_ip_whitelist client_ip_whitelists_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_ip_whitelist
    ADD CONSTRAINT client_ip_whitelists_pkey PRIMARY KEY (id);


--
-- TOC entry 3013 (class 2606 OID 195488)
-- Name: client_users client_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_users
    ADD CONSTRAINT client_users_pkey PRIMARY KEY (id);


--
-- TOC entry 2983 (class 2606 OID 182130)
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- TOC entry 3015 (class 2606 OID 195490)
-- Name: client_users clientuser_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_users
    ADD CONSTRAINT clientuser_email_unique UNIQUE (email);


--
-- TOC entry 3023 (class 2606 OID 195578)
-- Name: configurations config_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configurations
    ADD CONSTRAINT config_name_unique UNIQUE (name);


--
-- TOC entry 3025 (class 2606 OID 195576)
-- Name: configurations configurations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configurations
    ADD CONSTRAINT configurations_pkey PRIMARY KEY (id);


--
-- TOC entry 3005 (class 2606 OID 195150)
-- Name: aauth_users email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT email_unique UNIQUE (email) INCLUDE (email);


--
-- TOC entry 3007 (class 2606 OID 195152)
-- Name: aauth_users man_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT man_number_unique UNIQUE (man_number);


--
-- TOC entry 3019 (class 2606 OID 195531)
-- Name: request_charges request_charge_year_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.request_charges
    ADD CONSTRAINT request_charge_year_unique UNIQUE (year);


--
-- TOC entry 3021 (class 2606 OID 195519)
-- Name: request_charges request_charges_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.request_charges
    ADD CONSTRAINT request_charges_pkey PRIMARY KEY (id);


--
-- TOC entry 3017 (class 2606 OID 195507)
-- Name: requests requests_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requests
    ADD CONSTRAINT requests_pkey PRIMARY KEY (id);


--
-- TOC entry 3030 (class 2606 OID 195195)
-- Name: aauth_perm_to_group aauth_perm_to_group_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3031 (class 2606 OID 195200)
-- Name: aauth_perm_to_group aauth_perm_to_group_groupfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_groupfk FOREIGN KEY ("group") REFERENCES public.aauth_groups(id);


--
-- TOC entry 3032 (class 2606 OID 195205)
-- Name: aauth_perm_to_group aauth_perm_to_group_permfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_permfk FOREIGN KEY (permission) REFERENCES public.aauth_perms(id);


--
-- TOC entry 3033 (class 2606 OID 195210)
-- Name: aauth_perm_to_group aauth_perm_to_group_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_group
    ADD CONSTRAINT aauth_perm_to_group_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3034 (class 2606 OID 195215)
-- Name: aauth_perm_to_user aauth_perm_to_user_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3035 (class 2606 OID 195220)
-- Name: aauth_perm_to_user aauth_perm_to_user_permissionfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_permissionfk FOREIGN KEY (permission) REFERENCES public.aauth_perms(id);


--
-- TOC entry 3036 (class 2606 OID 195225)
-- Name: aauth_perm_to_user aauth_perm_to_user_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3037 (class 2606 OID 195230)
-- Name: aauth_perm_to_user aauth_perm_to_user_userfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_perm_to_user
    ADD CONSTRAINT aauth_perm_to_user_userfk FOREIGN KEY ("user") REFERENCES public.aauth_users(id);


--
-- TOC entry 3038 (class 2606 OID 195240)
-- Name: aauth_user_files aauth_user_files_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_files
    ADD CONSTRAINT aauth_user_files_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- TOC entry 3039 (class 2606 OID 195245)
-- Name: aauth_user_files aauth_user_files_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_files
    ADD CONSTRAINT aauth_user_files_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- TOC entry 3040 (class 2606 OID 195250)
-- Name: aauth_user_files aauth_user_files_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_files
    ADD CONSTRAINT aauth_user_files_user_fk FOREIGN KEY ("user") REFERENCES public.aauth_users(id);


--
-- TOC entry 3041 (class 2606 OID 195255)
-- Name: aauth_user_to_group aauth_user_to_group_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3042 (class 2606 OID 195260)
-- Name: aauth_user_to_group aauth_user_to_group_groupfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_groupfk FOREIGN KEY ("group") REFERENCES public.aauth_groups(id) NOT VALID;


--
-- TOC entry 3043 (class 2606 OID 195265)
-- Name: aauth_user_to_group aauth_user_to_group_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3044 (class 2606 OID 195270)
-- Name: aauth_user_to_group aauth_user_to_group_userfk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_user_to_group
    ADD CONSTRAINT aauth_user_to_group_userfk FOREIGN KEY ("user") REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3045 (class 2606 OID 195280)
-- Name: aauth_users aauth_users_group_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_users
    ADD CONSTRAINT aauth_users_group_fk FOREIGN KEY ("group") REFERENCES public.aauth_groups(id);


--
-- TOC entry 3027 (class 2606 OID 192959)
-- Name: client_attributes clientattributes_client_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_attributes
    ADD CONSTRAINT clientattributes_client_fk FOREIGN KEY (client) REFERENCES public.clients(id);


--
-- TOC entry 3046 (class 2606 OID 195491)
-- Name: client_users clientuser_client_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_users
    ADD CONSTRAINT clientuser_client_fk FOREIGN KEY (client) REFERENCES public.clients(id);


--
-- TOC entry 3050 (class 2606 OID 195579)
-- Name: configurations configs_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configurations
    ADD CONSTRAINT configs_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- TOC entry 3051 (class 2606 OID 195584)
-- Name: configurations configs_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configurations
    ADD CONSTRAINT configs_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- TOC entry 3028 (class 2606 OID 195355)
-- Name: aauth_groups groups_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_groups
    ADD CONSTRAINT groups_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3029 (class 2606 OID 195360)
-- Name: aauth_groups groups_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.aauth_groups
    ADD CONSTRAINT groups_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id) NOT VALID;


--
-- TOC entry 3026 (class 2606 OID 182139)
-- Name: client_ip_whitelist ipwhitelist_client_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client_ip_whitelist
    ADD CONSTRAINT ipwhitelist_client_fk FOREIGN KEY (client) REFERENCES public.clients(id);


--
-- TOC entry 3048 (class 2606 OID 195520)
-- Name: request_charges request_charges_createdby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.request_charges
    ADD CONSTRAINT request_charges_createdby_fk FOREIGN KEY (created_by) REFERENCES public.aauth_users(id);


--
-- TOC entry 3049 (class 2606 OID 195525)
-- Name: request_charges request_charges_updatedby_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.request_charges
    ADD CONSTRAINT request_charges_updatedby_fk FOREIGN KEY (updated_by) REFERENCES public.aauth_users(id);


--
-- TOC entry 3047 (class 2606 OID 195508)
-- Name: requests request_client_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requests
    ADD CONSTRAINT request_client_fk FOREIGN KEY (client) REFERENCES public.clients(id);


-- Completed on 2023-01-10 00:35:21 CAT

--
-- PostgreSQL database dump complete
--

