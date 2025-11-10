/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     09/11/2025 21.09.52                          */
/*==============================================================*/


drop table if exists ADMIN;

drop table if exists DOKUMEN;

drop table if exists JURUSAN;

drop table if exists PENDAFTARAN;

drop table if exists SISWA;

/*==============================================================*/
/* Table: ADMIN                                                 */
/*==============================================================*/
create table ADMIN
(
   ID_ADMIN             int not null auto_increment,
   NAMA_ADMIN           varchar(255),
   USERNAME_ADMIN       varchar(255),
   PASSWORD_ADMIN       varchar(255),
   primary key (ID_ADMIN)
);

/*==============================================================*/
/* Table: DOKUMEN                                               */
/*==============================================================*/
create table DOKUMEN
(
   ID_DOKUMEN           int not null auto_increment,
   ID_PENDAFTARAN       int,
   KETERANGAN           varchar(255),
   JENIS_DOKUMEM        varchar(255),
   PATH_FILE            varchar(255),
   primary key (ID_DOKUMEN)
);

/*==============================================================*/
/* Table: JURUSAN                                               */
/*==============================================================*/
create table JURUSAN
(
   ID_JURUSAN           int not null auto_increment,
   NAMA_JURUSAN         varchar(255),
   primary key (ID_JURUSAN)
);

/*==============================================================*/
/* Table: PENDAFTARAN                                           */
/*==============================================================*/
create table PENDAFTARAN
(
   ID_PENDAFTARAN       int not null auto_increment,
   NISN_SISWA           varchar(255),
   ID_JURUSAN           int,
   TANGGAL_PENDAFTARAN  varchar(255),
   NAMA_WALI            varchar(255),
   NO_HP_WALI           varchar(255),
   STATUS               varchar(255),
   JURUSAN              varchar(255),
   primary key (ID_PENDAFTARAN)
);

/*==============================================================*/
/* Table: SISWA                                                 */
/*==============================================================*/
create table SISWA
(
   NISN_SISWA           varchar(255) not null,
   NAMA_LENGKAP_SISWA   varchar(255),
   ALAMAT_SISWA         varchar(255),
   TANGGAL_LAHIR_SISWA  date,
   JENIS_KELAMIN_SISWA  varchar(255),
   NO_TELPON_SISWA      varchar(255),
   FOTO_SISWA_SISWA     varchar(255),
   PASSWORD_SISWA       varchar(255),
   primary key (NISN_SISWA)
);

alter table DOKUMEN add constraint FK_MEMILIKI_DOKUMEN foreign key (ID_PENDAFTARAN)
      references PENDAFTARAN (ID_PENDAFTARAN) on delete restrict on update restrict;

alter table PENDAFTARAN add constraint FK_MELAKUKAN foreign key (NISN_SISWA)
      references SISWA (NISN_SISWA) on delete restrict on update restrict;

alter table PENDAFTARAN add constraint FK_RELATIONSHIP_3 foreign key (ID_JURUSAN)
      references JURUSAN (ID_JURUSAN) on delete restrict on update restrict;

