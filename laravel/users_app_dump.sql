--
-- PostgreSQL database dump
--

-- Dumped from database version 15.13 (Debian 15.13-1.pgdg120+1)
-- Dumped by pg_dump version 15.13 (Debian 15.13-1.pgdg120+1)

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: users_app; Type: TABLE; Schema: public; Owner: admin
--

CREATE TABLE public.users_app (
    id_role integer NOT NULL,
    id_user integer NOT NULL,
    fio character varying(128),
    email character varying(128),
    hash_password text
);


ALTER TABLE public.users_app OWNER TO admin;

--
-- Name: users_app_id_user_seq; Type: SEQUENCE; Schema: public; Owner: admin
--

CREATE SEQUENCE public.users_app_id_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_app_id_user_seq OWNER TO admin;

--
-- Name: users_app_id_user_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: admin
--

ALTER SEQUENCE public.users_app_id_user_seq OWNED BY public.users_app.id_user;


--
-- Name: users_app id_user; Type: DEFAULT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.users_app ALTER COLUMN id_user SET DEFAULT nextval('public.users_app_id_user_seq'::regclass);


--
-- Data for Name: users_app; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.users_app (id_role, id_user, fio, email, hash_password) FROM stdin;
3	2	╨Ъ╤А╨░╤Б╨╜╤Л╤Е ╨Р╨╜╨┤╤А╨╡╨╣ ╨Р╨╗╨╡╨║╤Б╨░╨╜╨┤╤А╨╛╨▓╨╕╤З	dordo164@gmail.com	$2y$12$1bbvYmYnGyQypT0GUESks.pgUqTD1WOfo7eBy2UhgsEjBMBqG/zda
\.


--
-- Name: users_app_id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.users_app_id_user_seq', 2, true);


--
-- Name: users_app pk_users_app; Type: CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.users_app
    ADD CONSTRAINT pk_users_app PRIMARY KEY (id_role, id_user);


--
-- Name: has_unique_fk; Type: INDEX; Schema: public; Owner: admin
--

CREATE INDEX has_unique_fk ON public.users_app USING btree (id_role);


--
-- Name: user_pk; Type: INDEX; Schema: public; Owner: admin
--

CREATE UNIQUE INDEX user_pk ON public.users_app USING btree (id_role, id_user);


--
-- Name: users_app fk_users_role; Type: FK CONSTRAINT; Schema: public; Owner: admin
--

ALTER TABLE ONLY public.users_app
    ADD CONSTRAINT fk_users_role FOREIGN KEY (id_role) REFERENCES public.role(id_role);


--
-- PostgreSQL database dump complete
--

