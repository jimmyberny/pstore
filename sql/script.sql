-- Script para la papeleria
create database papeleria;
use papeleria;

create table rol(
    id varchar(40) not null,
    nombre varchar(40) not null,
    tipo varchar(40) not null,
    inicio varchar(40) not null,
    constraint pk_rol primary key(id)
) engine = InnoDB;

insert into rol(id, nombre, tipo, inicio) 
    values ('random', 'Administrador', 'admin', 'home.php');

create table usuario (
    id varchar(40) not null,
    nombre varchar(120) not null,
    paterno varchar(60) not null,
    materno varchar(60) null,
    id_rol varchar(40) not null,
    usuario varchar(20) not null unique,
    contra varchar(40) not null,
    constraint pk_usuario primary key(id),
    constraint fk_u_r_rol foreign key(id_rol) references rol(id)
) engine = InnoDB;

insert into usuario (id, nombre, paterno, materno, id_rol, usuario, contra)
    values ('random', 'Administrador', 'paterno', 'materno', 'random', 'admin', 'admin');

create table categoria (
    id varchar(40) not null,
    nombre varchar(60) not null unique,
    constraint pk_categoria primary key(id)
) engine = InnoDB;

create table producto (
    id varchar(40) not null,
    nombre varchar(60) not null,
    codigo varchar(20) not null,
    descripcion varchar(200) not null,
    existencia double not null default 0,
    minimo double not null,
) engine = InnoDB;

