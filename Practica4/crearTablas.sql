

-- Este fichero es para crear las tablas de la base de datos e insertar algunas filas en las tablas
-- Pero no está pensado para ejecutarlo, sino para ir copiando cada sentencia e ir ejecutandola manualmente en la base de datos

create table tags(
    id int auto_increment primary key,
    id_evento int references eventos(id),
    descripcion TEXT
);

insert into tags (id_evento, descripcion) values (1, 'Martin Garrix');
insert into tags (id_evento, descripcion) values (1, 'DeadMau5');
insert into tags (id_evento, descripcion) values (1, 'David Guetta');



create table eventos(
    id INT auto_increment PRIMARY KEY,
    nombre VARCHAR(100),
    lugar VARCHAR(200),
    fecha VARCHAR(200),
    organizadores VARCHAR(200),
    path_foto_cabecera TEXT,
    descripcion TEXT,
    twitter TEXT,
    facebook TEXT
);

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook) 
values ('Tomorrowland 2021', 'Boom, Belgica', 'del 16 al 18, y del 23 al 25 Julio', 'We Are One World, Tomorrowland Foundation y LiveStyle', 'images/tomorrowland.jpg',
'Tomorrowland es un festival de musica electronica de baile celebrado anualmente en la localidad de Boom (Belgica). El festival es organizado por las empresas propias del festival (We Are One World y Tomorrowland Foundation) en conjuncion con la promotora estadounidense LiveStyle, y se calcula que anualmente acuden mas de 400.000 personas de casi 200 nacionalidades distintas. Es oficialmente el festival mas grande del planeta.

A mediados de la decada de los 00, los hermanos Manu y Michiel Beers, quienes trabajaban en la empresa holandesa promotora de eventos, ID&T, concibieron la idea de crear este evento, en un paraje cercano al municipio de Boom, Belgica. La primera edicion del festival se llevo a cabo el 11 de agosto de 2005 en el Area Recreativa Provincial DeSchorre, en la comuna y municipio de Boom. En ella actuaron Armin van Buuren, David Guetta, Coone, entre otros.El festival era organizado, ano con ano, por la empresa holandesa ID&T, hasta que, en el ano 2013 se anuncio la compra de esta empresa por parte de la promotora de eventos con sede en Los Angeles, LiveStyle, de forma que, la organizacion del evento, paso desde ese ano a LiveStyle directamente. Asi mismo, los hermanos Beers, decidieron fundar una empresa (We Are One World), y una fundacion (Tomorrowland Foundation), las cuales, en conjunto con LiveStyle, hasta la fecha se encargan de organizar dicho festival.

Su nombre -Tomorrowland: La tierra del manana en espanol, los escenarios y el ambiente se encuentran rodeados de una decoracion que simula un mundo de magia y fantasia. El festival en si, ofrece una variedad de subgeneros dentro de la musica electronica. Asi mismo, consta de un camping a las afueras del recinto del festival, llamado DreamVille, para aquellos asistentes que deseen hospedarse lo mas cerca posible. "DreamVille" ofrece distintas comodidades, ya sea un lugar donde poner tu propia tienda de campana o una mansion para un determinado numero de personas. Anadido a esto, la entrada al DreamVille ofrece poder asistir a "The Gathering", una pre-fiesta al festival realizada desde el mediodia del jueves hasta pasada la media noche y que suele incluir la participacion de djs incluidos en el line-up del fin de semana.

The preparations for Tomorrowland 2021 are currently ongoing. Governmental instructions will be followed up closely during these preparations. The well-being, health, and safety of the People of Tomorrow, our partners, our neighbors, the artists, and our team are still our top priority. We hope we will be able to celebrate love, unity, and friendship with all of you next summer. Every visitor will be updated with open and transparent communication about Tomorrowland 2021 as soon as we have more information.
IMPORTANT UPDATE
For 2021 only, Tomorrowland will be moved to :

Weekend 1: August 27, 28 and 29
Weekend 2: September 3, 4 and 5
We want to stay positive and hopeful towards an unforgettable end of summer of 2021, but realize that there is also a chance the 16th edition of Tomorrowland could take place in 2022. We expect to come back to you in May with a detailed update. For now, we will keep working hard to realize the most beautiful & safest festival.

Together with the People of Tomorrow, we believe in better times. We will unite again.',
'https://twitter.com/tomorrowland', 'https://es-es.facebook.com/tomorrowland/'
);

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook)  values 
('CreamFields 2021', 'Warrington, Reino Unido', 'del 26 al 29 de Agosto', 'Cream & LiveNation', 'images/creamfields-2018.jpg',
'Creamfields es un festival de musica electronica celebrado anualmente cada mes de agosto en Liverpool (Reino Unido) desde 1998, organizado por los responsables del club nocturno Cream, club privado del cual se deriva el nombre de su evento musical "Creamfields". Cuenta con la participacion de varios DJ en vivo.

Festivales Creamfields se han realizado fuera de Reino Unido en:

Europa: Almeria, Vigo (Espana), Lisboa (Portugal), Mangalia (Rumania), Moscu (Rusia), Praga (Republica Checa), Punchestown (Irlanda), Rabat (Malta), Wroclaw (Polonia), Estambul (parte europea perteneciente a Turquia).

America: Buenos Aires (Argentina), Santiago (Chile), Ciudad de Mexico (Mexico), Punta del Este (Uruguay), Rio de Janeiro, Curitiba, Belo Horizonte (Brasil), Lima (Peru), Bogota (Colombia) y Asuncion (Paraguay).

Creamfields surgio en Inglaterra en 1998, con la idea de ofrecer un festival de musica electronica y entretenimiento en un gran espacio al aire libre.

A lo largo de los anos, Creamfields se consolido como el festival favorito del publico: es la pista de baile mas grande del mundo y tiene una propuesta artistica que une a grandes exponentes de la escena electronica internacional, con figuras locales consolidadas y talentos emergentes.

Desde hace diez anos, Creamfields es uno de los mejores festivales del genero en el mundo y presenta, por show, mas de 90 artistas nacionales e internacionales, una disposicion del espacio unica dentro de un predio de caracteristicas excepcionales, lo que ratifica su enorme fama mundial por la calidad artistica del festival.

Creamfields es el unico festival que logro extender con exito el concepto de musica y entretenimiento al aire libre y traslado su propuesta de montaje a gran escala, escenarios al aire libre y carpas con diferentes formatos a mas de 15 paises, como Argentina, Chile, Brasil, Uruguay, Peru, Australia, Espana, Emiratos Arabes, entre otros.

DJs pioneros y bandas exponentes de la musica electronica como Chemical Brothers, Faithless, Basement Jaxx, Groove Armada, Underworld, Fatboy Slim, Hernan Cattaneo, John Digweed, Sasha y Paul Oakenfold participaron en las diferentes ediciones del festival y deslumbraron con sus sets a mas de 50.000 personas por show.
On 9 August 2004, British DJ Paul Oakenfold released his fifteenth DJ Mix album entitled Creamfields. The album was released in advance of the sixth edition of the festival in 2004 of which Oakenfold was due to perform. The album itself is third in a series of remix album with the other two being made by other DJs. In 2019, Oakenfold released a further DJ mix album to celebrate the festivals twentieth anniversary.

The 2016 edition of Creamfields saw the debut of the Steel Yard stage at the main event in Daresbury, Cheshire. The stage is a 15,000 capacity super structure designed and built by Acorn Events.

Steel Yard Liverpool made its debut in 2016 at the citys Clarence Graving Dock, and now occurs annually in late November or early December.

Steel Yard London initially took place in late October at Victoria Park, London in 2017, before moving to Finsbury Park for 2018 and 2019 respectively, with a new date on the late-May bank holiday weekend.

In 2018, Steel Yard Liverpool partnered with Tomorrowland and Dimitri Vegas & Like Mike to bring "Garden of Madness" to the UK for a special one-off event.',
'https://twitter.com/creamfields','https://www.facebook.com/OfficialCreamfields/'
);

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook)
values ('Mad Cool Festival 2021', 'Madrid, España', '7-10 Julio', '???', 'images/madcool.jpg', 'descripcion por completar','https://twitter.com/','https://www.facebook.com/');

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook)
values ('Arenal Sound 2021', 'Burrianas, Valencia', '27 Julio - 1 Agosto', '???', 'images/arenal-sound.jpg', 'descripcion por completar','https://twitter.com/','https://www.facebook.com/');

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook)
values ('Dreambeach 2021', 'Villaricos, Almería', '4-8 Agosto', '???', 'images/dreambeach.jpg', 'descripcion por completar','https://twitter.com/','https://www.facebook.com/');

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook)
values ('Defqon 1 2021', 'Biddinghuizen, Países Bajos', '25-27 Junio', '???', 'images/defqon1.jpg', 'descripcion por completar','https://twitter.com/','https://www.facebook.com/');

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook)
values ('EDC Portugal 2021', 'Praia da Rocha, Portugal', '18-20 Junio', '???', 'images/edc_portugal.jpg', 'descripcion por completar','https://twitter.com/','https://www.facebook.com/');

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook)
values ('Mysteryland 2021', 'Ámsterdam, Paises Bajos', '27-29 Agosto', '???', 'images/mysteryland.jpg', 'descripcion por completar','https://twitter.com/','https://www.facebook.com/');

insert into eventos (nombre, lugar, fecha, organizadores, path_foto_cabecera, descripcion, twitter, facebook)
values ('Coachella 2021', 'California, Estados Unidos' ,'9-11 Abril', '???', 'images/Coachella.jpg', 'descripcion por completar','https://twitter.com/','https://www.facebook.com/');





create table fotos(
    id int auto_increment primary key,
    id_evento int references eventos(id),
    path_imagen text,
    caption varchar(200)
);

insert into fotos (id_evento, path_imagen, caption)
values (1, 'images/Tomorrowland-2019-Mainstage.jpg', 'Tomorrowland Main Stage 2019');

insert into fotos (id_evento, path_imagen, caption)
values (1, 'images/backstage_tomorrowland.jpg', 'Tomorrowland desde la tarima');

insert into fotos (id_evento, path_imagen, caption)
values (2, 'images/creamfields_stage1.jpg', 'Creamfields Stage 2019');

insert into fotos (id_evento, path_imagen, caption)
values (2, 'images/creamfields_stage2.jpg', 'Creamfields Stage 2017');




-- create table comentarios(
--     id_evento int references eventos(id),
--     id_comentario int,
--     nombre_usuario varchar(200),
--     email varchar(220),
--     descripcion text,
--     fecha datetime,
--     primary key (id_evento, id_comentario)
-- );

-- insert into comentarios (id_evento, id_comentario, nombre_usuario, email, descripcion, fecha) values 
-- (1, 1, 'Antonio el pipas', 'tonypipillas@gmail.com', 'Deseando ir ya al festival', '2021-03-23 13:37:50');

-- insert into comentarios (id_evento, id_comentario, nombre_usuario, email, descripcion, fecha) values 
-- (1, 2, 'Rasho_Mcqueeeen', 'kachow@gmail.com', 'Tomorroland best festival in da world', '2021-04-05 02:26:34');

create table comentarios(
    id_comentario int auto_increment PRIMARY KEY,
    id_evento int references eventos(id),
    id_usuario int references usuarios(id),
    descripcion text,
    fecha datetime
    -- primary key (id_evento, id_comentario)
);

insert into comentarios (id_evento, id_usuario, descripcion, fecha) values 
(1, 1, 'Deseando ir ya al festival', '2021-03-23 13:37:50');

insert into comentarios (id_evento, id_usuario, descripcion, fecha) values 
(1, 2, 'Tomorroland best festival in da world', '2021-04-05 02:26:34');





create table palabras_ban(
    palabra varchar(220) primary key
);

insert into palabras_ban (palabra) values ('de locos');
insert into palabras_ban (palabra) values ('amputar');
insert into palabras_ban (palabra) values ('joder');
insert into palabras_ban (palabra) values ('joputa');
insert into palabras_ban (palabra) values ('fuck');
insert into palabras_ban (palabra) values ('moron');
insert into palabras_ban (palabra) values ('imbecil');





create table usuarios(
    id int auto_increment primary key,
    nombre varchar(220),
    pass varchar(255),
    email varchar(255),
    fecha_nacimiento date,
    moderador int,
    gestor int,
    super int
);

//la contraseña es '123456' con el hash metido
insert into usuarios (nombre, pass, email, fecha_nacimiento, moderador, gestor, super) values 
('Yo', '$2y$10$g8RcsUHOyW7pJHlSARsbBepdkxJD5j8zlsni7EVLOexj04wZtMO0i', 'j.navarro.merino01@gmail.com', '2001-02-04', 1, 1, 1);