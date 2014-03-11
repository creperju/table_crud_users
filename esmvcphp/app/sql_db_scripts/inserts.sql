/*
 * @file: dables_and_user.sql
 * @author: jequeto@gmail.com
 * @since: 2012 enero
*/

-- use daw2;

set names utf8;
set sql_mode = 'traditional';


/* ******************************************* */
/* Para la aplicación esmvcphp (todos)         */
/* ******************************************* */

insert into daw2_roles
  (rol					, descripcion) values
  ('administradores'	,'Administradores de la aplicación')
, ('usuarios'		,'Todos los usuarios incluido anónimo')
, ('usuarios_logueados'	,'Todos los usuarios excluido anónimo')
;


insert into daw2_usuarios 
  (login, email, password, fecha_alta ,fecha_confirmacion_alta, clave_confirmacion) values
  ('admin', 'admin@email.com', md5('admin00'), default, now(), null)
, ('anonimo', 'anonimo@email.com', md5(''), default, now(), null)
, ('juan', 'juan@email.com', md5('juan00'), default, now(), null)
, ('anais', 'anais@email.com', md5('anais00'), default, now(), null)
;

insert into daw2_metodos
  (controlador,		metodo) values
  ('*'			,'*')
, ('inicio'		,'*')
, ('inicio'		,'index')
, ('inicio'		,'internacional')

, ('tabla'              ,'*')
, ('tabla'              ,'index')
, ('tabla'              ,'form_insertar')
, ('tabla'              ,'form_modificar')
, ('tabla'              ,'form_borrar')

, ('mensajes'		, '*')

, ('roles'		,'*')
, ('roles'		,'index')
, ('roles'		,'form_borrar')
, ('roles'		,'form_insertar')
, ('roles'		,'form_modificar')

, ('roles_permisos'	,'*')
, ('roles_permisos'	,'index')
, ('roles_permisos'	,'form_modificar')

, ('usuarios'		,'*')
, ('usuarios'		,'index')
, ('usuarios'		,'desconectar')
, ('usuarios'		,'form_login')
, ('usuarios'		,'form_login_validar')
, ('usuarios'		,'form_cambiar_password')
, ('usuarios'		,'form_login_email')
, ('usuarios'		,'form_login_email_validar')
, ('usuarios'		,'confirmar_alta')
, ('usuarios'		,'form_insertar_interno')
, ('usuarios'		,'form_insertar_externo')
, ('usuarios'		,'form_modificar')
, ('usuarios'		,'form_borrar')

, ('usuarios_permisos'	,'*')
, ('usuarios_permisos'	,'index')
, ('usuarios_permisos'	,'form_modificar')

;

insert into daw2_roles_permisos
  (rol			,controlador		,metodo) values
  ('administradores'	,'*'			,'*')
, ('usuarios'		,'mensajes'		,'*')
, ('usuarios'		,'inicio'		,'*')
, ('usuarios'		,'tabla'		,'index')
, ('usuarios_logueados'	,'tabla'		,'index')
, ('usuarios_logueados'	,'tabla'		,'form_insertar')
, ('usuarios_logueados' ,'usuarios'		,'desconectar')
, ('usuarios_logueados' ,'usuarios'		,'form_cambiar_password')

;

insert into daw2_usuarios_roles
  (login		,rol) values
  ('admin'		,'administradores')
, ('juan'		,'administradores')
/*, ('anonimo'	,'usuarios')
-- , ('juan'		,'usuarios')
-- , ('juan'		,'usuarios_logueados')
-- , ('anais'		,'usuarios')
-- , ('anais'		,'usuarios_logueados')*/
;


insert into daw2_usuarios_permisos
  (login		,controlador		,metodo) values
  ('anonimo'		,'usuarios'		,'form_login')
, ('anonimo'		,'usuarios'		,'form_login_email')
, ('anonimo'		,'usuarios'		,'form_insertar_externo')
, ('anonimo'		,'usuarios'		,'confirmar_alta')
;



truncate table daw2_menu;
insert into daw2_menu
  (id, es_submenu_de_id	, nivel	, orden	, texto, accion_controlador, accion_metodo, title) values
  (1 , null				, 1		, null	, 'Inicio', 'inicio', 'index', null)
, (2 , null				, 1		, null	, 'Internacional', 'inicio', 'internacional', null)
, (3 , null				, 1		, null	, 'Libros', 'libros', 'index', null)
, (4 , null				, 1		, null	, 'Revista', 'revista', 'index', null)
, (5 , null				, 1		, null	, 'Usuarios', 'usuarios', 'index', null)
, (6 , null				, 1		, null	, 'Categorías', 'categorias', 'index', null)
, (7 , null				, 1		, null	, 'Artículos', 'articulos', null, null)
, (8 , 7				, 2		, null	, 'listado', 'articulos', 'index', null)
, (9 , 7				, 2		, null	, 'recuento por categoría', 'articulos', 'recuento_por_categoria', null)
;



/******************************************
    DATOS PARA LA APP TABLE-CRUD-USERS
*******************************************/
insert into daw2_juegos
    (titulo ,                               plataforma, fabricante, fecha_de_lanzamiento,   precio) values
    ('Assassin`s Creed',                    'PC',       'Ubisoft',	'2008-10-21',       9.95    )
,   ('Assassin`s Creed II',                 'PC',       'Ubisoft',	'2010-03-03',       9.95    )
,   ('Alien Isolation',                     'X360',     'Sega',         '2014-12-31',       64.99   )
,   ('Castlevania Lords of Shadow 2',       'PS3',      'Konami',	'2014-02-27',       34.95   )
,   ('Donkey Kong Country Tropical Freeze', 'WIIU',     'Nintendo',	'2014-02-21',       42.95   )
,   ('Sonic Advance',                       'GBA',      'Sega',         '2002-03-07',       1.95    )   
;