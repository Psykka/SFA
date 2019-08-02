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
    nome varchar (255) not null,
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

create table condicao(
	idCondicao int(10) unsigned not null auto_increment,
    idMotivo int(10) unsigned default null, /* Motivo da falta se o funcionario faltou */
    condicao varchar(255) not null,
    foreign key (idMotivo) references motivo(idMotivo),
    primary key (idCondicao)
);

create table frequencia(
	idFrequencia int(10) unsigned not null auto_increment,
    idFunc int(10) unsigned not null,
    idCondicao int(10) unsigned not null,
    idHorario int(10) unsigned not null,
    dia date not null,
    foreign key (idFunc) references funcionario(idFunc),
    foreign key (idCondicao) references condicao(idCondicao),
    foreign key (idHorario) references horario(idHorario),
    primary key (idFrequencia)
);
