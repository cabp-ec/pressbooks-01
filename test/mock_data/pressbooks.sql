drop table if exists book;
drop table if exists language;
drop table if exists subject;

/* Table: book                                                  */
create table book
(
  id          int          not null auto_increment,
  identifier  int          not null,
  title       varchar(100) not null,
  url         varchar(200) not null,
  language    char(2)      not null,
  word_count  int          not null,
  is_original bool         not null default true,
  based_on    varchar(200),
  primary key (id)
);

/* Table: language                                              */
create table language
(
  lang_code char(2)     not null,
  lang_name varchar(32) not null,
  primary key (lang_code)
);

/* Table: subject                                               */
create table subject
(
  identifier int          not null auto_increment,
  name       varchar(100) not null,
  primary key (identifier)
);

alter table book
  add constraint fk_book_subject foreign key (identifier)
references subject (identifier)
  on delete restrict
  on update restrict;

