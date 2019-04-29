-- Generado por Oracle SQL Developer Data Modeler 19.1.0.081.0911
--   en:        2019-04-25 23:15:32 CEST
--   sitio:      Oracle Database 11g
--   tipo:      Oracle Database 11g

create Database if not exists scholae;

CREATE TABLE if not exists administradores (
    id          INTEGER NOT NULL auto_increment PRIMARY KEY,
    nombre      varchar(50),
    correo      varchar(50) NOT NULL,
    contrasena  text not null,
    username    varchar(50) NOT NULL,
    apellidos   varchar(50)
);

CREATE TABLE if not exists categorias (
    id_categoria            INTEGER NOT NULL auto_increment PRIMARY KEY,
    nom_categoria           varchar(50),
    noticias_id             INTEGER not null,
    panel_principal_id_pp   INTEGER not null, 
    pp_aside_id_pp_aside    INTEGER not null
);


CREATE TABLE if not exists noticias (
    id                      INTEGER NOT NULL auto_increment PRIMARY KEY,
    titulo                  varchar(50) NOT NULL,
    descripcion             text NOT NULL,
    foto                    varchar(50),
    archivo                 varchar(50),
    panel_principal_id_pp   INTEGER not null
);


CREATE TABLE if not exists panel_principal (
    id_pp    INTEGER NOT NULL auto_increment PRIMARY KEY,
    valor   INTEGER
);

CREATE TABLE pp_aside (
    id_pp_aside    INTEGER NOT NULL auto_increment PRIMARY KEY,
    titulo        varchar(50),
    descripcion   varchar(250),
    foto          varchar(100),
    archivo       varchar(300)
);

ALTER TABLE categorias
    ADD CONSTRAINT categorias_noticias_fk FOREIGN KEY ( noticias_id )
        REFERENCES noticias ( id );

ALTER TABLE categorias
    ADD CONSTRAINT categorias_panel_principal_fk FOREIGN KEY ( panel_principal_id_pp )
        REFERENCES panel_principal ( id_pp );

ALTER TABLE categorias
    ADD CONSTRAINT categorias_pp_aside_fk FOREIGN KEY ( pp_aside_id_pp_aside )
        REFERENCES pp_aside ( id_pp_aside );

ALTER TABLE noticias
    ADD CONSTRAINT noticias_panel_principal_fk FOREIGN KEY ( panel_principal_id_pp )
        REFERENCES panel_principal ( id_pp );



-- Informe de Resumen de Oracle SQL Developer Data Modeler: 
-- 
-- CREATE TABLE                             5
-- CREATE INDEX                             1
-- ALTER TABLE                              9
-- CREATE VIEW                              0
-- ALTER VIEW                               0
-- CREATE PACKAGE                           0
-- CREATE PACKAGE BODY                      0
-- CREATE PROCEDURE                         0
-- CREATE FUNCTION                          0
-- CREATE TRIGGER                           0
-- ALTER TRIGGER                            0
-- CREATE COLLECTION TYPE                   0
-- CREATE STRUCTURED TYPE                   0
-- CREATE STRUCTURED TYPE BODY              0
-- CREATE CLUSTER                           0
-- CREATE CONTEXT                           0
-- CREATE DATABASE                          0
-- CREATE DIMENSION                         0
-- CREATE DIRECTORY                         0
-- CREATE DISK GROUP                        0
-- CREATE ROLE                              0
-- CREATE ROLLBACK SEGMENT                  0
-- CREATE SEQUENCE                          0
-- CREATE MATERIALIZED VIEW                 0
-- CREATE MATERIALIZED VIEW LOG             0
-- CREATE SYNONYM                           0
-- CREATE TABLESPACE                        0
-- CREATE USER                              0
-- 
-- DROP TABLESPACE                          0
-- DROP DATABASE                            0
-- 
-- REDACTION POLICY                         0
-- 
-- ORDS DROP SCHEMA                         0
-- ORDS ENABLE SCHEMA                       0
-- ORDS ENABLE OBJECT                       0
-- 
-- ERRORS                                   2
-- WARNINGS                                 8

--CREATE UNIQUE INDEX noticias__idx ON--
      --noticias (--
        --panel_principal_id_pp--
    --ASC );--

--ALTER TABLE noticias ADD CONSTRAINT noticias_pk PRIMARY KEY ( id );--
""