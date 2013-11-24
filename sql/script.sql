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
    nombre varchar(60) not null,
    constraint pk_categoria primary key(id)
) engine = InnoDB;

create table producto (
    id varchar(40) not null,
    id_categoria varchar(20) not null,
    nombre varchar(60) not null,
    codigo varchar(20) not null,
    descripcion varchar(200) not null,
    existencia double not null default 0,
    minimo double not null,
    venta double not null,
    compra double not null,
    iva double not null, -- guardar el decimal para ahorra calculo
    constraint pk_producto primary key(id),
    constraint fk_p_c_categoria foreign key(id_categoria) references categoria(id)
) engine = InnoDB;

create table cliente (
    id varchar(40) not null,
    rfc varchar(20) null,
    nombre varchar(40) not null,
    paterno varchar(40) not null,
    materno varchar(40) null,
    proveedor integer not null, -- indica si un cliente tambien es un proveedor
    -- datos de domicilio
    calle varchar(40) null,
    interior varchar(10) null,
    exterior varchar(10) null,
    colonia varchar(40) null,
    ciudad varchar(40) null,
    estado varchar(40) null,
    constraint pk_cliente primary key(id)
) engine = InnoDB;

-- Ventas
create table caja(
    id varchar(40) not null,
    inicio datetime not null,
    fin datetime null,
    constraint pk_caja primary key(id)
) engine = InnoDB;

create table pago(
    id varchar(40) not null,
    id_ticket varchar(40) not null,
    importe double not null,
    recibido double not null,
    constraint pk_pago primary key(id),
    constraint fk_p_t_ticket foreign key(id_ticket) references ticket(id)
) engine = InnoDB;

create table ticket(
    id varchar(40) not null,
    id_caja varchar(40) not null,
    id_usuario varchar(40) not null,
    id_cliente varchar(40) null, -- puede o no tener cliente
    fecha datetime not null,
    constraint pk_ticket primary key(id),
    constraint fk_t_c_caja foreign key(id_caja) references caja(id),
    constraint fk_t_u_usuario foreign key(id_usuario) references usuario(id),
    constraint fk_t_c_cliente foreign key(id_cliente) references cliente(id)
) engine = InnoDB;

create table linea_ticket(
    id varchar(40) not null,
    id_ticket varchar(40) not null,
    orden integer not null,
    id_producto varchar(40) not null,
    cantidad double not null,
    precio double not null,
    impuesto double not null,
    constraint pk_linea_ticket primary key(id),
    constraint fk_lt_t_ticket foreign key(id_ticket) references ticket(id),
    constraint fk_lt_p_producto foreign key(id_producto) references producto(id)
) engine = InnoDB;

-- Ordenes de pedido
create table orden (
    id varchar(40) not null,
    id_cliente varchar(40) not null,
    fecha datetime not null,
    constraint pk_orden primary key(id),
    constraint fk_o_c_cliente foreign key(id_cliente) references cliente(id)
) engine = InnoDB;

create table linea_orden (
    id varchar(40) not null,
    id_orden varchar(40) not null,
    id_producto varchar(40) not null,
    cantidad double not null,
    constraint pk_linea_orden primary key(id),
    constraint fk_lo_o_orden foreign key(id_orden) references orden(id),
    constraint fk_lo_p_producto foreign key(id_producto) references producto(id)
) engine = InnoDB;