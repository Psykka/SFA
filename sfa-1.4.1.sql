create database SFA;

use SFA;

create table usuario(
	idUser int(10) unsigned not null auto_increment,
    username varchar(255) not null,
    passwd varchar(255) default null,
    primary key (idUser)
);

create table cargo(
	idCargo int(10) unsigned not null auto_increment,
	funcao varchar(255) not null,
    primary key (idCargo)
);

create table horario(
	idHorario int(10) unsigned not null auto_increment,
    dia varchar(30) not null,
	horaIni time not null,
    horaFin time not null,
    primary key (idHorario)
);

create table funcionario(
	idFunc int(10) unsigned not null auto_increment,
	idCargo int(10) unsigned not null,
    nome varchar(255) not null,
    rg varchar(255) not null,
    primary key (idFunc),
    foreign key (idCargo) references cargo(idCargo)
);

create table HorarioFuncinarios(
	idFunc int(10) unsigned not null,
    idHorario int(10) unsigned not null,
	foreign key (idFunc) references funcionario(idFunc),
    foreign key (idHorario) references horario(idHorario)
);

create table motivo(
	idMotivo int(10) unsigned not null auto_increment,
    motivo varchar(255),
    primary key (idMotivo)
);

create table frequencia(
	idFrequencia int(10) unsigned not null auto_increment,
    idFunc int(10) unsigned not null,
    idHorario int(10) unsigned not null,
    hora time not null,
    condicao int check(condicao in (0, 1)),
    status int default 0 check(status in (0, 1 , 2)), /* Visto do diretor */
    foreign key (idFunc) references funcionario(idFunc),
    foreign key (idHorario) references horario(idHorario),
    primary key (idFrequencia)
);

