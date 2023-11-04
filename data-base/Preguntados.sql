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
   imagen_path varchar(255) DEFAULT NULL,
   preguntas_contestadas INT(10) DEFAULT 0,
    preguntas_fallidas INT(10) DEFAULT 0,
    rol varchar(10) DEFAULT 'USER'

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
    entregadas INT(10) DEFAULT 0,
    contestada INT(10) DEFAULT 0,
    dificultad_id INT DEFAULT 1,
    FOREIGN KEY (dificultad_id) REFERENCES dificultad_pregunta(id)
);

DROP TABLE IF EXISTS dificultad_preguntas;
CREATE TABLE dificultad_preguntas (
id INT AUTO_INCREMENT PRIMARY KEY,
dificultad VARCHAR(50) NOT NULL
);

INSERT INTO dificultad_preguntas (dificultad) VALUES('Facil'),('Media'),('Dificil');

/*
-- Agregar la columna
ALTER TABLE preguntas
ADD COLUMN dificultad_id INT;

-- Agregar la fk
ALTER TABLE preguntas
ADD CONSTRAINT fk_dificultad
FOREIGN KEY (dificultad_id) REFERENCES dificultad_preguntas(id);*/

DROP TABLE IF EXISTS confirmacion_registros;
CREATE TABLE confirmacion_registros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo_electronico VARCHAR(255) NOT NULL,
    token VARCHAR(32) NOT NULL
);

DROP TABLE IF EXISTS opciones;
CREATE TABLE opciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT,
    opcion TEXT NOT NULL,
    opcion_correcta VARCHAR(2) DEFAULT 'NO',
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id)
);

INSERT INTO `preguntas` (`id`, `pregunta`, `estado`, `modulo`, `verificada`, `accesible`, `tipo`, `entregadas`, `contestada`, `dificultad_id`) VALUES
(1, 'Si en un script PHP encuentra una llamada a un método de clase de la siguiente manera: Usuario::traerUsuario(); Se trata de:', 'ACTIVA', 'MVC / POO', 'NO', 'NO', 'Opciones con respuesta única', 0, 0, 1),
(2, 'Cuando utilizo una Clase en forma estática siempre se ejecuta el método __construct()', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 1),
(3, 'La S del acrónimo SOLID es por el concepto Single Responsibility, que indica:', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 1),
(4, 'El concepto de acoplamiento refiere a:', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 1),
(5, 'Como concepto general podemos decir que a menos acoplamiento mejor software', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 1),
(6, 'En software se entiende por patrón de diseño a:', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 2, 0, 2),
(7, 'El patrón MVC se utiliza mucho en aplicaciones web porque:', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 2),
(8, 'En un modelo MVC el que recibe normalmente la petición del cliente es:', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 2),
(9, 'El modelo en un esquema MVC es el encargado de almacenar y ejecutar la lógica del negocio', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 2, 0, 2),
(10, 'Uno de los objetivos del modelo MVC es separar en la aplicación el modelo de negocios de las interfaces de usuario', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 2),
(11, 'El enrutador en un modelo MVC es el encargado de ejecutar las operaciones de acceso a la base de datos', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 3),
(12, 'El folding en una aplicación web se refiere a:', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 3),
(13, 'Si estoy desarrollando usando TDD estoy', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 3),
(14, 'El patrón MVC esta compuesto por:', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 3),
(15, 'En un patrón MVC la Vista es la encargada de', 'ACTIVA', 'MVC / POO', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 3),
(16, 'La principal diferencia entre los enfoques Responsive y Mobile First es', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 1),
(17, 'Observando la siguiente imagen, cuál de las dos opciones (A o B) le parece más adecuada para describir el enfoque Mobile first.', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 1),
(18, 'La principal diferencia entre una Aplicación Web y una Aplicación monolítica (por ejemplo una Win32) es:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 1),
(19, 'El protocolo a través del cuál se realiza todo el intercambio de datos entre un servidor web y un cliente es:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 1, 0, 2),
(20, 'El protocolo HTTP tiene entre sus características ser:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 2),
(21, 'El protocolo DNS es:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 2),
(22, 'El protocolo HTTP implementa comandos, entre ellos:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 3),
(23, 'El protocolo HTTP implementa códigos de error de respuesta, si recibo un código de la serie 500, ha ocurrido:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 3),
(24, 'El protocolo HTTP implementa códigos de error de respuesta, si recibo un código de la serie 400, ha ocurrido:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 3),
(25, 'El protocolo HTTP implementa códigos de error de respuesta, si recibo un código de la serie 200, ha ocurrido:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'SI', 'Opciones con respuesta única', 0, 0, 1),
(26, 'En una petición GET, los parámetros de la petición se pasan a través de....', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 1),
(27, 'Se denomina Scripting del lado del cliente, o programación Front-end o Client Side Scripting a:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 1),
(28, 'Se denomina Scripting del lado del servidor, o programación Back-end o Server Side Scripting a:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 2),
(29, 'La petición de un recurso determinado a un sitio Web (imagen, archivo, etc.) se canaliza mediante:', 'ACTIVA', 'Introducción a HTTP y a las Aplicaciones Web', 'SI', 'NO', 'Opciones con respuesta única', 0, 0, 2);

INSERT INTO opciones (pregunta_id, opcion, opcion_correcta) VALUES
(1, "Una llamada al método por referencia", 'NO'),
(1, "Un método de una Clase invocado en forma estática", 'SI'),
(1, "Llamada a un constructor", 'NO'),
(1, "Instanciación de una Clase", 'NO'),

(2, "Verdadero", 'NO'),
(2, "Falso", 'SI'),

(3, "Que una Clase solo debe ser instanciada para poder invocar un método de la misma", 'NO'),
(3, "Que una Clase debe cumplir la mayor cantidad de funciones dentro de mi modelo de negocios", 'NO'),
(3, "Que un objeto/clase debe tener una sola razón para cambiar, esto es debe tener un sólo trabajo", 'SI'),
(3, "Los objetos o clases deben estar abiertos por extensión, pero cerrados por modificación.", 'NO'),

(4, "al grado de interdependencia que tienen dos unidades de software entre sí", 'SI'),
(4, "al grado de independencia que tienen dos unidades de software entre sí", 'NO'),
(4, "al grado de comunicación que tienen dos unidades de software entre sí", 'NO'),
(4, "al grado de complejidad que tienen dos unidades de software", 'NO'),

(5, "Verdadero", 'SI'),
(5, "Falso", 'NO'),

(6, "Al dueño de un diseño determinado", 'NO'),
(6, "A un conjunto de técnicas aplicadas en conjunto para resolver problemas comunes al desarrollo de software", 'SI'),
(6, "Es la vertienrte de POO que se ocupa del desarrollo de interfaces", 'NO'),
(6, "Es la vertienrte de POO que se ocupa del desarrollo de interfaces", 'NO'),

(7, "Es mas lindo", 'NO'),
(7, "Es mas simple", 'NO'),
(7, "Representa bien la división de entornos en una aplicación web", 'SI'),
(7, "Esta desarrollado para explicar las interfaces desde una óptica de UX", 'NO'),

(8, "el controlador", 'NO'),
(8, "el modelo", 'NO'),
(8, "la vista", 'NO'),
(8, "el enrutador", 'SI'),

(9, "Verdadero", 'SI'),
(9, "Falso", 'NO'),

(10, "Verdadero", 'SI'),
(10, "Falso", 'NO'),

(11, "Verdadero", 'NO'),
(11, "Falso", 'SI'),

(12, "una forma de disponer de las consultas en la base de datos", 'NO'),
(12, "una forma de escribir el código de manera que sea legible", 'NO'),
(12, "una forma de ordenar el código de manera que el proyecto sea comprensible", 'SI'),
(12, "una forma de ordenar el código de manera que el proyecto sea comprensible", 'NO'),

(13, "Usando un método de programación basado en objetos", 'NO'),
(13, "Usando un método de programación basado en funciones", 'NO'),
(13, "Usando un método de programación basado en pruebas", 'NO'),
(13, "Usando un método de programación basado en test", 'SI'),

(14, "Un Modelo, una Vista y un Controlador, complementados por un enrutador", 'SI'),
(14, "Un Modelo, una Vista y un Controlador", 'NO'),
(14, "Un Modelo, una Versionador y un Controlador", 'NO'),
(14, "Un Microservicio, una Vista y un Controlador", 'NO'),

(15, "Resolver la comunicación con el usuario", 'SI'),
(15, "Comunicar al Controlador con el Modelo", 'NO'),
(15, "Resolver la lógica de negocios", 'NO'),
(15, "Resolver la petición del usuario", 'NO'),

(16, "Que el enfoque Mobile First se basa en CSS3 y HTML 5.", 'NO'),
(16, "Que el enfoque Mobile First se basa en la idea de diseñar pensando en el ambiente móvil y de allí llevar el diseño al desktop.", 'SI'),
(16, "En que el enfoque Responsive el sitio debe adaptarse a diferentes dispositivos y en el enfoque Mobile First no.", 'NO'),
(16, "Los dos enfoques son iguales, dos nombres para identificar o mismo.", 'NO'),
(16, "La 1 y 4 son correctas.", 'NO'),

(17, "A", 'NO'),
(17, "B", 'SI'),
(17, "A y B", 'NO'),
(17, "Ninguna de las anteriores", 'NO'),

(18, "Son escencialmente iguales", 'NO'),
(18, "Que una aplicación web hace uso de una red TCP/IP y una aplicación monolítica no.", 'NO'),
(18, "Que en una aplicación web es dividida en dos partes interdependientes, una en el cliente (visualización) y otra en el servidor (lógica de negocios, acceso a datos, etc.)", 'SI'),
(18, "1 y 2 son correctas", 'NO'),

(19, "HTTP/HTTPS", 'SI'),
(19, "DNS/HTTP", 'NO'),
(19, "REST", 'NO'),
(19, "1 y 2 son correctas", 'NO'),

(20, "No orientado a la conexión (Conectionless) / Sin mantenimiento de estado de conexión (Stateless)", 'SI'),
(20, "No orientado a la conexión (Conectionless) ", 'NO'),
(20, "Orientado a la conexión ", 'NO'),
(20, "Orientado al mantenimiento de estado de conexión ", 'NO'),

(21, "Un protocolo de resolución de espacios de procesamiento en un entorno distribuido", 'NO'),
(21, "Un protocolo de cifrado de 3 niveles usado en Internet", 'NO'),
(21, "Un protocolo de comunicación entre sitios web y sus clientes", 'NO'),
(21, "Un protocolo de resolución de nombres de caracteristicas jerárquicas", 'SI'),

(22, "GET, POST, HEAD", 'SI'),
(22, "SEND, PING, SAVE", 'NO'),
(22, "GET, SEND, PING", 'NO'),
(22, "GET, POST, SEND", 'NO'),

(23, "Nada, informa que el procesamiento finlaizo Ok", 'NO'),
(23, "Informa un error en la resolcuón DNS del nombre", 'NO'),
(23, "Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor", 'SI'),
(23, "Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente", 'NO'),

(24, "Nada, informa que el procesamiento finlaizo Ok", 'NO'),
(24, "Informa un error en la resolcuón DNS del nombre", 'NO'),
(24, "Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor", 'NO'),
(24, "Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente", 'SI'),

(25, "Nada, informa que el procesamiento finlaizo Ok", 'SI'),
(25, "Informa un error en la resolcuón DNS del nombre", 'NO'),
(25, "Informa que ha ocurrido un error en el procesamiento de la peticion en el servidor", 'NO'),
(25, "Informa que ha ocurrido un error en el procesamiento de la peticion en el cliente", 'NO'),

(26, "El cuerpo de la petición", 'NO'),
(26, "Abriendo un socket", 'NO'),
(26, "Como parte de la URL", 'SI'),
(26, "No se pueden pasar parametros en una peticion GET", 'NO'),

(27, "Porciones de código ejecutable que se envían al navegador del cliente para que este los ejecute", 'SI'),
(27, "Porciones de código ejecutable que el cliente envía para que se ejecuten en el servidor", 'NO'),
(27, "La parte del modelo de negocios que se ejecuta en el servidor", 'NO'),
(27, "Ninguna de las anteriores", 'NO'),

(28, "Porciones de codigo ejecutable que se envian al navegador del cliente para que este los ejecute", 'NO'),
(28, "Porciones de código ejecutable que se ejecutan en el servidor ante una petición del cliente", 'SI'),
(28, "La parte del modelo de negocios que se ejecuta en el cliente", 'NO'),
(28, "Ninguna de las anteriores", 'NO'),

(29, "Una URL", 'SI'),
(29, "Un DNS", 'NO'),
(29, "Una API", 'NO'),
(29, "Ninguna de las anteriores", 'NO');


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