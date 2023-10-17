CREATE DATABASE IF NOT EXISTS preguntados;
USE preguntados;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
   id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   nombre_completo VARCHAR(255) NOT NULL,
   ano_nacimiento INT DEFAULT NULL,
   sexo ENUM('Masculino', 'Femenino', 'Prefiero no decirlo') DEFAULT NULL,
   pais VARCHAR(50) DEFAULT NULL,
   ciudad VARCHAR(50) DEFAULT NULL,
   mail VARCHAR(255) NOT NULL,
   password VARCHAR(255) NOT NULL,
   user_name VARCHAR(100) UNIQUE NOT NULL,
   imagen_path varchar(255) DEFAULT NULL

);

DROP TABLE IF EXISTS preguntas;
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta TEXT NOT NULL,
    estado VARCHAR(255) NOT NULL,
    modulo VARCHAR(100),
    verificada VARCHAR(2) DEFAULT 'NO',
    accesible VARCHAR(2) DEFAULT 'NO',
    tipo VARCHAR(100) NOT NULL,
    opcion VARCHAR(255) NOT NULL,
    opcion_correcta VARCHAR(10)
);

INSERT INTO preguntas(pregunta,estado,modulo,verificada,accesible,tipo,opcion,opcion_correcta) VALUES 
('Si en un script PHP encuentra una llamada a un método de clase de la siguiente manera:
Usuario::traerUsuario();
Se trata de:','ACTIVA','MVC / POO','NO','NO','Opciones con respuesta única','Una llamada al método por referencia','NO'),
('Si en un script PHP encuentra una llamada a un método de clase de la siguiente manera:
Usuario::traerUsuario();
Se trata de:','ACTIVA','MVC / POO','NO','NO','Opciones con respuesta única','Un métido de una Clase invocado en forma estática','SI'),
('Si en un script PHP encuentra una llamada a un método de clase de la siguiente manera:
Usuario::traerUsuario();
Se trata de:','ACTIVA','MVC / POO','NO','NO','Opciones con respuesta única','Llamada a un constructor','NO'),
('Si en un script PHP encuentra una llamada a un método de clase de la siguiente manera:
Usuario::traerUsuario();
Se trata de:','ACTIVA','MVC / POO','NO','NO','Opciones con respuesta única','Instanciación de una Clase','NO'),
('Cuando utilizo una Clase en forma estática siempre se ejecuta el método __construct()','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Verdadero','NO'),
('Cuando utilizo una Clase en forma estática siempre se ejecuta el método __construct()','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Falso','SI'),
('La S del acrónimo SOLID es por el concepto Single Responsability, que indica:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Que una Clase solo debe ser instanciada para poder invocer un método de la misma','NO'),
('La S del acrónimo SOLID es por el concepto Single Responsability, que indica:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Que una Clase debe cumplir la mayor cantidad de funciones dentro de mi modelo de negocios','NO'),
('La S del acrónimo SOLID es por el concepto Single Responsability, que indica:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Que un objeto/clase debe tener una sola razón para cambiar, esto es debe tener un sólo trabajo','SI'),
('La S del acrónimo SOLID es por el concepto Single Responsability, que indica:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Los objetos o clases deben estar abiertos por extensión, pero cerrados por modificación.','NO'),
('El concepto de acoplamiento refiere a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','al grado de interdependencia que tienen dos unidades de software entre sí','SI'),
('El concepto de acoplamiento refiere a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','al grado de independencia que tienen dos unidades de software entre sí','NO'),
('El concepto de acoplamiento refiere a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','al grado de comunicación que tienen dos unidades de software entre sí','NO'),
('El concepto de acoplamiento refiere a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','al grado de complejidad que tienen dos unidades de software','NO'),
('Como concepto general podemos decir que a menos acoplamiento mejor software','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Verdadero','SI'),
('Como concepto general podemos decir que a menos acoplamiento mejor software','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Falso','NO'),
('En software se entiende por patrón de diseño a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Al dueño de un diseño determinado','NO'),
('En software se entiende por patrón de diseño a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','A un conjunto de técnicas aplicadas en conjunto para resolver problemas comunes al desarrollo de software','SI'),
('En software se entiende por patrón de diseño a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Es la vertienrte de POO que se ocupa del desarrollo de interfaces','NO'),
('En software se entiende por patrón de diseño a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','En POO se denomina así a una clase que funciona como una librería en Porcedural','NO'),
('El patrón MVC se utiliza mucho en aplicaciones web porque:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Es mas lindo','NO'),
('El patrón MVC se utiliza mucho en aplicaciones web porque:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Es mas simple','NO'),
('El patrón MVC se utiliza mucho en aplicaciones web porque:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Representa bien la división de entornos en una aplicación web','SI'),
('El patrón MVC se utiliza mucho en aplicaciones web porque:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Esta desarrollado para explicar las interfaces desde una óptica de UX','NO'),
('En un modelo MVC el que recibe normalmente la petición del cliente es:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','el controlador','NO'),
('En un modelo MVC el que recibe normalmente la petición del cliente es:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','el modelo','NO'),
('En un modelo MVC el que recibe normalmente la petición del cliente es:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','la vista','NO'),
('En un modelo MVC el que recibe normalmente la petición del cliente es:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','el enrutador','SI'),
('El modelo en un esquema MVC es el encargado de almacenar y ejecutar la lógica del negocio','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Verdadero','SI'),
('El modelo en un esquema MVC es el encargado de almacenar y ejecutar la lógica del negocio','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Falso','NO'),
('Uno de los objetivos del modelo MVC es separar en la aplicación el modelo de negocios de las interfaces de usuario','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Verdadero','SI'),
('Uno de los objetivos del modelo MVC es separar en la aplicación el modelo de negocios de las interfaces de usuario','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Falso','NO'),
('El enrutador en un modelo MVC es el encargado de ejecutar las operaciones de acceso a la base de datos','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Verdadero','NO'),
('El enrutador en un modelo MVC es el encargado de ejecutar las operaciones de acceso a la base de datos','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Falso','SI'),
('El folding en una aplicación web se refiere a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','una forma de disponer de las consultas en la base de datos','NO'),
('El folding en una aplicación web se refiere a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','una forma de escribir el código de manera que sea legible','NO'),
('El folding en una aplicación web se refiere a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','una forma de ordenar el código de manera que el proyecto sea comprensible','SI'),
('El folding en una aplicación web se refiere a:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','un método de foldear vistas','NO'),
('Si estoy desarrollando usando TDD estoy','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Usando un método de programación basado en objetos','NO'),
('Si estoy desarrollando usando TDD estoy','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Usando un método de programación basado en funciones','NO'),
('Si estoy desarrollando usando TDD estoy','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Usando un método de programación basado en pruebas','NO'),
('Si estoy desarrollando usando TDD estoy','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Usando un método de programación basado en test','SI'),
('El patrón MVC esta compuesto por:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Un Modelo, una Vista y un Controlador, complementados por un enrutador','SI'),
('El patrón MVC esta compuesto por:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Un Modelo, una Vista y un Controlador','NO'),
('El patrón MVC esta compuesto por:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Un Modelo, una Versionador y un Controlador','NO'),
('El patrón MVC esta compuesto por:','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Un Microservicio, una Vista y un Controlador','NO'),
('En un patrón MVC la Vista es la encargada de ','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Resolver la comunicación con el usuario','SI'),
('En un patrón MVC la Vista es la encargada de ','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Comunicar al Controlador con el Modelo','NO'),
('En un patrón MVC la Vista es la encargada de ','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Resolver la lógica de negocios','NO'),
('En un patrón MVC la Vista es la encargada de ','ACTIVA','MVC / POO','SI','NO','Opciones con respuesta única','Resolver la petición del usuario','NO'),
('La principal diferencia entre los enfoques Responsive y Mobile First es','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Que el enfoque Mobile First se basa en CSS3 y HTML 5.','NO'),
('La principal diferencia entre los enfoques Responsive y Mobile First es','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Que el enfoque Mobile First se basa en la idea de diseñar pensando en el ambiente móvil y de allí llevar el diseño al desktop.','SI'),
('La principal diferencia entre los enfoques Responsive y Mobile First es','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','En que el enfoque Responsive el sitio debe adaptarse a diferentes dispositivos y en el enfoque Mobile First no.','NO'),
('La principal diferencia entre los enfoques Responsive y Mobile First es','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Los dos enfoques son iguales, dos nombres para identificar o mismo.','NO'),
('La principal diferencia entre los enfoques Responsive y Mobile First es','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','La 1 y 4 son correctas','NO'),
('Observando la siguiente imagen, cuál de las dos opciones (A o B) le parece más adecuada para describir el enfoque Mobile first.','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','A','NO'),
('Observando la siguiente imagen, cuál de las dos opciones (A o B) le parece más adecuada para describir el enfoque Mobile first.','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','B','SI'),
('Observando la siguiente imagen, cuál de las dos opciones (A o B) le parece más adecuada para describir el enfoque Mobile first.','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','A y B','NO'),
('Observando la siguiente imagen, cuál de las dos opciones (A o B) le parece más adecuada para describir el enfoque Mobile first.','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Ninguna de las anteriores','NO'),
('La principal diferencia entre una Aplicación Web y una Aplicación monolítica (por ejemplo una Win32) es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Son escencialmente iguales','NO'),
('La principal diferencia entre una Aplicación Web y una Aplicación monolítica (por ejemplo una Win32) es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Que una aplicación web hace uso de una red TCP/IP y una aplicación monolítica no.','NO'),
('La principal diferencia entre una Aplicación Web y una Aplicación monolítica (por ejemplo una Win32) es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Que en una aplicación web es dividida en dos partes interdependientes, una en el cliente (visualización) y otra en el servidor (lógica de negocios, acceso a datos, etc.)','SI'),
('La principal diferencia entre una Aplicación Web y una Aplicación monolítica (por ejemplo una Win32) es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','1 y 2 son correctas','NO'),
('El protocolo a través del cuál se realiza todo el intercambio de datos entre un servidor web y un cliente es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','HTTP/HTTPS','SI'),
('El protocolo a través del cuál se realiza todo el intercambio de datos entre un servidor web y un cliente es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','DNS/HTTP','NO'),
('El protocolo a través del cuál se realiza todo el intercambio de datos entre un servidor web y un cliente es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','REST','NO'),
('El protocolo a través del cuál se realiza todo el intercambio de datos entre un servidor web y un cliente es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','1 y 2 son correctas','NO'),
('El protocolo HTTP tiene entre sus caracteristicas ser:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','No orientado a la conexión (Conectionless) / Sin mantenimiento de estado de conexión (Stateless)','SI'),
('El protocolo HTTP tiene entre sus caracteristicas ser:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','No orientado a la conexión (Conectionless) ','NO'),
('El protocolo HTTP tiene entre sus caracteristicas ser:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Orientado a la conexión ','NO'),
('El protocolo HTTP tiene entre sus caracteristicas ser:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Orientado al mantenimiento de estado de conexión ','NO'),
('El protocolo DNS es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Un protocolo de resolución de espacios de procesamiento en un entorno distribuido','NO'),
('El protocolo DNS es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Un protocolo de cifrado de 3 niveles usado en Internet','NO'),
('El protocolo DNS es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Un protocolo de comunicación entre sitios web y sus clientes','NO'),
('El protocolo DNS es:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Un protocolo de resolución de nombres de caracteristicas jerárquicas','SI'),
('El protocolo HTTP implementa comandos, entre ellos:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','GET, POST, HEAD','SI'),
('El protocolo HTTP implementa comandos, entre ellos:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','SEND, PING, SAVE','NO'),
('El protocolo HTTP implementa comandos, entre ellos:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','GET, SEND, PING','NO'),
('El protocolo HTTP implementa comandos, entre ellos:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','GET, POST, SEND','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 500, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Nada, informa que el procesamiento finlaizo Ok','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 500, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa un error en la resolcuón DNS del nombre','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 500, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor','SI'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 500, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 400, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Nada, informa que el procesamiento finlaizo Ok','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 400, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa un error en la resolcuón DNS del nombre','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 400, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 400, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente','SI'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 200, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Nada, informa que el procesamiento finlaizo Ok','SI'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 200, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa un error en la resolcuón DNS del nombre','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 200, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor','NO'),
('El protyocolo HTTP implementa codigos de error de respuesta, si recibo un codigo de la serie 200, ha ocurrido:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','SI','Opciones con respuesta única','Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente','NO'),
('En una petición GET, los parametros de la petición se pasan a través de....','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','El cuerpo de la petición','NO'),
('En una petición GET, los parametros de la petición se pasan a través de....','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Abriendo un socket','NO'),
('En una petición GET, los parametros de la petición se pasan a través de....','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Como parte de la URL','SI'),
('En una petición GET, los parametros de la petición se pasan a través de....','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','No se pueden pasar parametros en una peticion GET','NO'),
('Se denomina Scripting del lado del cliente, o programación Front-end o Client Side Scripting a :','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute','SI'),
('Se denomina Scripting del lado del cliente, o programación Front-end o Client Side Scripting a :','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Porciones de codigo ejecutable que el cliente envia para quese ejecuten en el servidor','NO'),
('Se denomina Scripting del lado del cliente, o programación Front-end o Client Side Scripting a :','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','La parte del modelo de negocios que se ejecuta en el servidor','NO'),
('Se denomina Scripting del lado del cliente, o programación Front-end o Client Side Scripting a :','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Ninguna de las anteriores','NO'),
('Se denomina Scripting del lado del servidor, o programación Back-end o Server Side Scripting a :','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute','NO'),
('Se denomina Scripting del lado del servidor, o programación Back-end o Server Side Scripting a :','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Porciones de código ejecutable que se ejecutan en el servidor ante una petición del cliente','SI'),
('Se denomina Scripting del lado del servidor, o programación Back-end o Server Side Scripting a :','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','La parte del modelo de negocios que se ejecuta en el cliente','NO'),
('Se denomina Scripting del lado del servidor, o programación Back-end o Server Side Scripting a :','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Ninguna de las anteriores','NO'),
('La petición de un recurso determinado a un sitio Web (imagen, archivo, etc.) se canaliza mediante:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Una URL','SI'),
('La petición de un recurso determinado a un sitio Web (imagen, archivo, etc.) se canaliza mediante:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Un DNS','NO'),
('La petición de un recurso determinado a un sitio Web (imagen, archivo, etc.) se canaliza mediante:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Una API','NO'),
('La petición de un recurso determinado a un sitio Web (imagen, archivo, etc.) se canaliza mediante:','ACTIVA','Introduccion a HTTP y a las Aplicaciones Web','SI','NO','Opciones con respuesta única','Ninguna de las anteriores','NO');

DROP TABLE IF EXISTS partidas;
CREATE TABLE partidas (
   id INT AUTO_INCREMENT PRIMARY KEY,
   user_id INT NOT NULL,
   puntaje VARCHAR(255) NOT NULL,
   FOREIGN KEY (user_id) REFERENCES users(id)
);

DROP TABLE IF EXISTS ranking;
CREATE TABLE ranking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    puntaje VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);