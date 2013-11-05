-- Script para la papeleria
create database papeleria;
use papeleria;

create table usuario (
    id varchar(40) not null,
    nombre varchar(120) not null,
    paterno varchar(60) not null,
    materno varchar(60) null,
    usuario varchar(20) not null unique,
    contra varchar(40) not null,
    constraint pk_usuario primary key(id)
) engine = InnoDB;

insert into usuario values ('random', 'Administrador', 'paterno', 'materno', 'admin', 'admin');

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

