UPDATE cob_actaconteo_persona, cob_actaconteo_persona_facturacion 
SET cob_actaconteo_persona.id_actaconteo_persona_facturacion = cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion 
WHERE cob_actaconteo_persona.id_contrato = cob_actaconteo_persona_facturacion.id_contrato 
AND cob_actaconteo_persona.numDocumento = cob_actaconteo_persona_facturacion.numDocumento 
AND cob_actaconteo_persona.id_periodo = 6 
AND cob_actaconteo_persona_facturacion.id_periodo = 6

SELECT cob_actaconteo_persona.id_actaconteo_persona, cob_actaconteo_persona.id_actaconteo_persona_facturacion 
FROM   cob_actaconteo_persona, cob_actaconteo_persona_facturacion
WHERE  cob_actaconteo_persona.id_contrato = cob_actaconteo_persona_facturacion.id_contrato 
  AND cob_actaconteo_persona.numDocumento = cob_actaconteo_persona_facturacion.numDocumento 
  AND cob_actaconteo_persona.id_periodo = 6 
  AND cob_actaconteo_persona_facturacion.id_periodo = 6

  UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona 
  SET cob_actaconteo_persona_facturacion.acta1 = cob_actaconteo_persona.id_actaconteo, 
  cob_actaconteo_persona_facturacion.asistencia1 = cob_actaconteo_persona.asistencia 
  WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion 
  AND  cob_actaconteo_persona.recorrido = 1 
  AND  cob_actaconteo_persona.id_periodo = 6 
  AND  cob_actaconteo_persona_facturacion.id_periodo = 6

  SELECT cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion
  FROM  cob_actaconteo_persona_facturacion, cob_actaconteo_persona 
  WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion 
  AND  cob_actaconteo_persona.recorrido = 1 
  AND  cob_actaconteo_persona.id_periodo = 6 
  AND  cob_actaconteo_persona_facturacion.id_periodo = 6

  UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona 
  SET cob_actaconteo_persona_facturacion.acta1 = cob_actaconteo_persona.id_actaconteo, 
  cob_actaconteo_persona_facturacion.asistencia1 = cob_actaconteo_persona.asistencia 
  WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion 
  AND cob_actaconteo_persona.recorrido = 1 
  AND cob_actaconteo_persona.id_periodo = 6 
  AND cob_actaconteo_persona_facturacion.id_periodo = 6


  UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona 
  SET cob_actaconteo_persona_facturacion.acta2 = cob_actaconteo_persona.id_actaconteo, 
  cob_actaconteo_persona_facturacion.asistencia2 = cob_actaconteo_persona.asistencia 
  WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion 
  AND cob_actaconteo_persona.recorrido = 2 
  AND cob_actaconteo_persona.id_periodo = 6
  AND cob_actaconteo_persona_facturacion.id_periodo = 6


    SELECT  cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion
  FROM cob_actaconteo_persona_facturacion, cob_actaconteo_persona 
  WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion 
  AND cob_actaconteo_persona.recorrido = 2 
  AND cob_actaconteo_persona.id_periodo = 6
  AND cob_actaconteo_persona_facturacion.id_periodo = 6