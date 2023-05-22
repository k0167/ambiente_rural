-- Database: ambiente_rural

-- DROP DATABASE IF EXISTS ambiente_rural;

CREATE DATABASE ambiente_rural
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;

-- Table: public.MUNICIPIO

-- DROP TABLE IF EXISTS public."MUNICIPIO";

CREATE TABLE IF NOT EXISTS public."MUNICIPIO"
(
    "COD_MUN" serial PRIMARY KEY,
    "NOME_MUN" character varying(100) COLLATE pg_catalog."default" NOT NULL,
    "UF_MUN" character varying(2) COLLATE pg_catalog."default" NOT NULL
);

-- Table: public.PRODUTO

-- DROP TABLE IF EXISTS public."PRODUTO";

CREATE TABLE IF NOT EXISTS public."PRODUTO"
(
    "COD_PRODUTO" serial PRIMARY KEY,
    "DESC_PRODUTO" character varying(100) COLLATE pg_catalog."default" NOT NULL
);


-- Table: public.PROPRIEDADE

-- DROP TABLE IF EXISTS public."PROPRIEDADE";

CREATE TABLE IF NOT EXISTS public."PROPRIEDADE"
(
    "COD_PROPRIEDADE" serial PRIMARY KEY,
    "NOME_PROPRIEDADE" character varying(100) COLLATE pg_catalog."default",
    "AREA" numeric(8,3),
    "DISTANCIA_DO_MUNIC" numeric(8,3),
    "VALOR_AQUISICAO" numeric(12,2)
);

-- Table: public.PROPRIETARIO

-- DROP TABLE IF EXISTS public."PROPRIETARIO";

CREATE TABLE IF NOT EXISTS public."PROPRIETARIO"
(
    "COD_PROPRIETARIO" serial PRIMARY KEY,
    "NOME_PROPRIETARIO" character varying(100) COLLATE pg_catalog."default" NOT NULL,
    "FONE1" character varying(11) COLLATE pg_catalog."default" NOT NULL,
    "FONE2" character varying(11) COLLATE pg_catalog."default",
    "FONE3" character varying(11) COLLATE pg_catalog."default"
);

-- Table: public.PESSOA_F

-- DROP TABLE IF EXISTS public."PESSOA_F";

CREATE TABLE IF NOT EXISTS public."PESSOA_F"
(
    "COD_PROP_PF" integer NOT NULL,
    "CPF_PROP" integer NOT NULL,
    "NOME_PF" character varying(100) COLLATE pg_catalog."default" NOT NULL,
    "DT_NASC_PF" date NOT NULL,
    "RG_PF" bigint NOT NULL,
    "COD_PROP_CONJUGE" integer NOT NULL,
    CONSTRAINT "PESSOA_F_pkey" PRIMARY KEY ("COD_PROP_PF"),
    CONSTRAINT "PESSOA_F_UNI" UNIQUE ("CPF_PROP"),
    CONSTRAINT "PESSOA_F_FK" FOREIGN KEY ("COD_PROP_PF")
        REFERENCES public."PROPRIETARIO" ("COD_PROPRIETARIO") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
);

-- Table: public.PESSOA_J

-- DROP TABLE IF EXISTS public."PESSOA_J";

CREATE TABLE IF NOT EXISTS public."PESSOA_J"
(
    "COD_PROP_PJ" integer NOT NULL,
    "CNPJ" integer NOT NULL,
    "RAZAO_SOCIAL_PJ" character varying(100) COLLATE pg_catalog."default" NOT NULL,
    "DT_CRIA_PJ" date NOT NULL,
    CONSTRAINT "PESSOA_J_pkey" PRIMARY KEY ("COD_PROP_PJ"),
    CONSTRAINT "PESSOA_J_UNI" UNIQUE ("CNPJ"),
    CONSTRAINT "PESSOA_J_FK" FOREIGN KEY ("COD_PROP_PJ")
        REFERENCES public."PROPRIETARIO" ("COD_PROPRIETARIO") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

-- Table: public.PRODUCAO

-- DROP TABLE IF EXISTS public."PRODUCAO";

CREATE TABLE IF NOT EXISTS public."PRODUCAO"
(
	"COD_PRODUCAO" serial PRIMARY KEY,
    "COD_PROPRIED" integer NOT NULL,
    "COD_PROD" integer NOT NULL,
    "MES_INI_COLHEITA_PROV" date NOT NULL,
    "MES_FIM_COLHEITA_PROV" date NOT NULL,
    "QTD_PROV_COLHEITA" numeric(10,2) NOT NULL,
    "MES_INI_COLHEITA_REAL" date,
    "MES_FIM_COLHEITA_REAL" date,
    "QTD_REAL_COLHIDA" numeric(10,2),
    CONSTRAINT "PRODUCAO_PROD_FK" FOREIGN KEY ("COD_PROD")
        REFERENCES public."PRODUTO" ("COD_PRODUTO") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT "PRODUCAO_PROPRI_FK" FOREIGN KEY ("COD_PROPRIED")
        REFERENCES public."PROPRIEDADE" ("COD_PROPRIEDADE") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

-- Table: public.PROPRIETARIO_PROPRIEDADE

-- DROP TABLE IF EXISTS public."PROPRIETARIO_PROPRIEDADE";

CREATE TABLE IF NOT EXISTS public."PROPRIETARIO_PROPRIEDADE"
(
    "COD_PROPRIED" integer NOT NULL,
    "COD_PROPRIET" integer NOT NULL,
    "DT_AQUISICAO" date NOT NULL,
    CONSTRAINT "PROPRIETARIO_PROPRIEDADE_pkey" PRIMARY KEY ("COD_PROPRIED", "COD_PROPRIET"),
    CONSTRAINT "PROD_PROPRIED" FOREIGN KEY ("COD_PROPRIED")
        REFERENCES public."PROPRIEDADE" ("COD_PROPRIEDADE") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT "PROD_PROPRIET" FOREIGN KEY ("COD_PROPRIET")
        REFERENCES public."PROPRIETARIO" ("COD_PROPRIETARIO") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

-- Table: public.DONO_PJ

-- DROP TABLE IF EXISTS public."DONO_PJ";''

CREATE TABLE IF NOT EXISTS public."DONO_PJ"
(
    "COD_PROP_PF" integer NOT NULL,
    "COD_PROP_PJ" integer NOT NULL,
    CONSTRAINT "DONO_PJ_pkey" PRIMARY KEY ("COD_PROP_PF", "COD_PROP_PJ"),
    CONSTRAINT "DONO_PJ_PROP_PF_FK" FOREIGN KEY ("COD_PROP_PF")
        REFERENCES public."PESSOA_F" ("COD_PROP_PF") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT "DONO_PJ_PROP_PJ_FK" FOREIGN KEY ("COD_PROP_PJ")
        REFERENCES public."PESSOA_J" ("COD_PROP_PJ") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);