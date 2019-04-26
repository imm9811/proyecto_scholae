-- Generado por Oracle SQL Developer Data Modeler 19.1.0.081.0911
--   en:        2019-04-25 23:15:32 CEST
--   sitio:      Oracle Database 11g
--   tipo:      Oracle Database 11g



CREATE TABLE administradores (
    id          INTEGER NOT NULL,
    nombre      VARCHAR2(50 CHAR),
    correo      VARCHAR2(50 CHAR) NOT NULL,
    username    VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    apellidos   VARCHAR2(50 CHAR)
);

ALTER TABLE administradores ADD CONSTRAINT administradores_pk PRIMARY KEY ( id );

CREATE TABLE categorias (
    id_categoria            INTEGER NOT NULL,
    nom_categoria           VARCHAR2(50 CHAR),
    noticias_id             CHAR 
--  WARNING: CHAR size not specified 
     NOT NULL,
    panel_principal_id_pp   CHAR 
--  WARNING: CHAR size not specified 
     NOT NULL,
    pp_aside_id_pp_aside    CHAR 
--  WARNING: CHAR size not specified 
     NOT NULL
);

ALTER TABLE categorias ADD CONSTRAINT categorias_pk PRIMARY KEY ( id_categoria );

CREATE TABLE noticias (
    id                      INTEGER NOT NULL,
    titulo                  VARCHAR2(50) NOT NULL,
    descripcion             VARCHAR2(500 CHAR) NOT NULL,
    foto                    VARCHAR2(50 CHAR),
    archivo                 VARCHAR2(50 CHAR),
    panel_principal_id_pp   CHAR 
--  WARNING: CHAR size not specified 
     NOT NULL
);

CREATE UNIQUE INDEX noticias__idx ON
    noticias (
        panel_principal_id_pp
    ASC );

ALTER TABLE noticias ADD CONSTRAINT noticias_pk PRIMARY KEY ( id );

CREATE TABLE panel_principal (
    id_pp    INTEGER NOT NULL,
    valor   INTEGER
);

ALTER TABLE panel_principal ADD CONSTRAINT panel_principal_pk PRIMARY KEY ( id_pp );

CREATE TABLE pp_aside (
    id_pp_aside    INTEGER NOT NULL,
    titulo        VARCHAR2(50 CHAR),
    descripcion   VARCHAR2(250),
    foto          VARCHAR2(50 CHAR),
    archivo       VARCHAR2(300 CHAR)
);

ALTER TABLE pp_aside ADD CONSTRAINT pp_aside_pk PRIMARY KEY ( id_pp_aside );

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
