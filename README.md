# tpe_web2_3raEntrega

Descripción Endpoints:

 + Colección completa:

 -/api/vinoteca --> METODO GET lista la colección completa de vinos;

 + Filtrar por bodega o por cepa o por ambos campos:

 -/api/vinoteca/?Nombre_bodega=Bodega Septima --> METODO GET lista los vinos filtrados por campo bodega (ej: Bodega Septima);
 -/api/vinoteca/?Nombre_cepa=Malbec --> METODO GET lista los vinos filtrados por campo cepa (ej: Malbec);
 -/api/vinoteca/?Nombre_bodega=Bodega Septima&Nombre_cepa=Malbec --> METODO GET filtra por ambos campos;

 + Ordenar por cualquiera de sus campos, en forma asc o desc:

 -/api/vinoteca/?sort=ID_vino --> METODO GET lista los vinos ordenados por defecto en forma asc (ej: por ID_vino);
 -/api/vinoteca/?sort=Nombre&order=asc --> METODO GET lista los vinos ordenados en forma asc (ej: por Nombre);
 -/api/vinoteca/?sort=Tipo&order=desc --> METODO GET lista los vinos ordenados en forma desc (ej: por Tipo);

 + Paginación (se establece la cant de 10 por página):

 -/api/vinoteca/?page=1 --> METODO GET lista los primeros 10 vinos (ej: page=1);

 -- Aclaración: Se pueden combinar cualquiera de las opciones anteriores. --

 + Obtener un vino por ID:

 -/api/vinoteca/2 --> METODO GET obtiene un vino (ej: vino con ID_vino= 2);

 + Obtener cualquiera de sus subrecursos:

 -/api/vinoteca/1/Nombre --> METODO GET obtiene el subrecurso de un vino (ej: el nombre del vino ID_vino= 1);

 + Autenticación:

 -/api/user/token--> METODO GET Este enpoint permite que el usuario se loguee a través de Basic Auth. El Username es "webadmin", y Password es "admin". Al ingresar se obtiene el token. Este Token es necesario para modificar vinos (PUT) y agregar vinos (POST). 

 + Agregar un vino (requiere autorización):
 
 -/api/vinoteca --> METODO POST
        Para agregar un vino se require un Token. Por ello se debe ir a Authorization, Type Bearer Token, pegar el Token obtenido, y luego ir al body para poder agregar un vino. La forma de agregar es colocar en el body lo siguiente:
                {
                    "Nombre": "FEDERICO LÓPEZ GRAN RESERVA",
                    "Tipo": "Vino blanco",
                    "Azucar": "dulce",
                    "id_cepa": 1,
                    "id_bodega": 2
                }

 + Modificar un vino (requiere autorización):
 
 -/api/vinoteca/2 -->METODO PUT
        Para modificar un vino tambien se require un Token. Por ello se debe ir a Authorization, Type Bearer Token, pegar el Token obtenido, y luego ir al body para poder agregar un vino. La forma de modificar es colocar en el body lo siguiente:
                {
                    "ID_vino": 2,
                    "Nombre": "FEDERICO LÓPEZ GRAN RESERVA",
                    "Tipo": "Vino blanco",
                    "Azucar": "dulce",
                    "id_cepa": 2,
                    "id_bodega": 3
                }

 + Eliminar un vino:
 
 -/api/vinoteca/3 -->METODO DELETE Se selecciona el verbo DELETE y se elimina segun el id que colocamos en el edpoint.
