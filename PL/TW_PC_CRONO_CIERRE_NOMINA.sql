create or replace PROCEDURE TW_PC_CRONO_CIERRE_NOMINA
/********************OBJETIVO: GENERA EL CRONOGRAMA DE CIERRE DE CIERRE DE NOVEDADES DE NOMINA*******************************
CREADO POR       : NELSON GALEANO
   
--PARAMETROS DE SALIDA   
  -- BLOQUE1          
************************************  DECLARACION DE VARIABLE  ************************************************************ */
(
    BLOQUE1     OUT SYS_REFCURSOR  
) 
IS
BEGIN
    -- EL PARAMETRO AÑO SE DEJA QUEMADO POR QUE LA BASE DE DATOS ESTA MUY DESACTUALIZADA Y NO TRAE DATOS DEL AÑO ACTUAL
    OPEN BLOQUE1 FOR
    select to_char(to_date(to_char(cod_per),'mm'),'Month','NLS_DATE_LANGUAGE = SPANISH') AS MES,
    to_char(fec_cie,'Day', 'NLS_DATE_LANGUAGE = SPANISH') AS DIA,
    EXTRACT (DAY FROM FEC_CIE) AS CIERRE,
    to_char(fec_pag,'Day', 'NLS_DATE_LANGUAGE = SPANISH') AS DIA_CIERRE,
    EXTRACT (DAY FROM FEC_PAG) AS PAGO
    from CIERRE_NOVPAG
    WHERE ANO = '2013'--EXTRACT (YEAR FROM SYSDATE)
    ORDER BY COD_PER ASC;  
    
END TW_PC_CRONO_CIERRE_NOMINA;