ALTER TABLE TELEPRU.T_ROLES
 DROP PRIMARY KEY CASCADE;

DROP TABLE TELEPRU.T_ROLES CASCADE CONSTRAINTS;

CREATE TABLE TELEPRU.T_ROLES
(
  COD_ROL      NUMBER                           NOT NULL,
  TIPO_ROL     VARCHAR2(50 BYTE)                NOT NULL,
  SENTENCIA    VARCHAR2(1000 BYTE)              NOT NULL,
  DESCRIPCION  VARCHAR2(200 BYTE)
)
TABLESPACE TELEFONICA
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
           )
LOGGING 
NOCOMPRESS 
NOCACHE
MONITORING;


--  There is no statement for index TELEPRU.SYS_C0015722.
--  The object is created when the parent object is created.

CREATE OR REPLACE PUBLIC SYNONYM T_ROLES FOR TELEPRU.T_ROLES;


ALTER TABLE TELEPRU.T_ROLES ADD (
  PRIMARY KEY
  (COD_ROL)
  USING INDEX
    TABLESPACE TELEFONICA
    PCTFREE    10
    INITRANS   2
    MAXTRANS   255
    STORAGE    (
                INITIAL          64K
                MINEXTENTS       1
                MAXEXTENTS       UNLIMITED
                PCTINCREASE      0
                BUFFER_POOL      DEFAULT
               )
  ENABLE VALIDATE);
