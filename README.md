# tpe_web2_3raEntrega
Descripción Endpoints:
    -/api/user/token--> METODO GET
        Este enpoint permite que el usuario se loguee a través de Basic Auth. El Username es "webadmin", y Password es "admin". Al ingresar se obtiene el token. Este Token es necesario para modificar vinos (PUT) y agregar vinos (POST).
    - api/vinoteca --> METODO POST
        Para agregar un vino se require un Token. Por ello se debe ir a Authorization, Type Bearer Token, pegar el Token obtenido, y luego ir al body para poder agregar un vino. La forma de agregar es colocar en el body lo siguiente:
                {
                    "Nombre": "FEDERICO LÓPEZ GRAN RESERVA",
                    "Tipo": "Vino blanco",
                    "Azucar": "dulce",
                    "id_cepa": 1,
                    "id_bodega": 2
                }
    - api/vinoteca/2 -->METODO PUT
        Para modificar un vino tambien se require un Token. Por ello se debe ir a Authorization, Type Bearer Token, pegar el Token obtenido, y luego ir al body para poder agregar un vino. La forma de modificar es colocar en el body lo siguiente:
                {
                    "ID_vino": 2,
                    "Nombre": "FEDERICO LÓPEZ GRAN RESERVA",
                    "Tipo": "Vino blanco",
                    "Azucar": "dulce",
                    "id_cepa": 2,
                    "id_bodega": 3
                }
    - api/vinoteca/39 -->METODO DELETE
        Se selecciona el verbo DELETE y se elimina segun el id que colocamos en el edpoint. 
