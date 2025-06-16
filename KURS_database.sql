/*==============================================================*/
/* DBMS name:      PostgreSQL 8                                 */
/* Created on:     16.06.2025 23:51:12                          */
/*==============================================================*/


drop index Processes_FK;

drop index Occurs_on_FK;

drop index Error_PK;

drop table Error;

drop index Implements_FK;

drop index Implements2_FK;

drop index Implements_PK;

drop table Implements;

drop index Forms_FK;

drop index Invoice_PK;

drop table Invoice;

drop index Writes_FK;

drop index Message_PK;

drop table Message;

drop index Network_device_PK;

drop table Network_device;

drop index Role_PK;

drop table Role;

drop index Includes_FK;

drop index Formalize_FK;

drop index Service_activation_PK;

drop table Service_activation;

drop index Services_PK;

drop table Services;

drop index Has_unique_FK;

drop index User_PK;

drop table "User";

drop index Leaves_FK;

drop index User_request_PK;

drop table User_request;

/*==============================================================*/
/* Table: Error                                                 */
/*==============================================================*/
create table Error (
   ID_device            INT4                 not null,
   Code_error           INT2                 not null,
   ID_role              INT4                 not null,
   ID_user              INT4                 not null,
   Status_error         BOOL                 not null,
   Description_error    VARCHAR(128)         not null,
   constraint PK_ERROR primary key (ID_device, Code_error)
);

/*==============================================================*/
/* Index: Error_PK                                              */
/*==============================================================*/
create unique index Error_PK on Error (
ID_device,
Code_error
);

/*==============================================================*/
/* Index: Occurs_on_FK                                          */
/*==============================================================*/
create  index Occurs_on_FK on Error (
ID_device
);

/*==============================================================*/
/* Index: Processes_FK                                          */
/*==============================================================*/
create  index Processes_FK on Error (
ID_role,
ID_user
);

/*==============================================================*/
/* Table: Implements                                            */
/*==============================================================*/
create table Implements (
   ID_services          INT4                 not null,
   ID_device            INT4                 not null,
   constraint PK_IMPLEMENTS primary key (ID_services, ID_device)
);

/*==============================================================*/
/* Index: Implements_PK                                         */
/*==============================================================*/
create unique index Implements_PK on Implements (
ID_services,
ID_device
);

/*==============================================================*/
/* Index: Implements2_FK                                        */
/*==============================================================*/
create  index Implements2_FK on Implements (
ID_device
);

/*==============================================================*/
/* Index: Implements_FK                                         */
/*==============================================================*/
create  index Implements_FK on Implements (
ID_services
);

/*==============================================================*/
/* Table: Invoice                                               */
/*==============================================================*/
create table Invoice (
   ID_role              INT4                 not null,
   ID_user              INT4                 not null,
   ID_connection        INT4                 not null,
   ID_invoice           SERIAL               not null,
   Sum_payment          DECIMAL              not null,
   Date_formation       DATE                 not null,
   Status_payment       BOOL                 not null,
   constraint PK_INVOICE primary key (ID_role, ID_user, ID_connection, ID_invoice)
);

/*==============================================================*/
/* Index: Invoice_PK                                            */
/*==============================================================*/
create unique index Invoice_PK on Invoice (
ID_role,
ID_user,
ID_connection,
ID_invoice
);

/*==============================================================*/
/* Index: Forms_FK                                              */
/*==============================================================*/
create  index Forms_FK on Invoice (
ID_role,
ID_user,
ID_connection
);

/*==============================================================*/
/* Table: Message                                               */
/*==============================================================*/
create table Message (
   ID_role              INT4                 not null,
   ID_user              INT4                 not null,
   ID_message           SERIAL               not null,
   Date_sending         DATE                 null,
   Content              VARCHAR(512)         null,
   constraint PK_MESSAGE primary key (ID_role, ID_user, ID_message)
);

/*==============================================================*/
/* Index: Message_PK                                            */
/*==============================================================*/
create unique index Message_PK on Message (
ID_role,
ID_user,
ID_message
);

/*==============================================================*/
/* Index: Writes_FK                                             */
/*==============================================================*/
create  index Writes_FK on Message (
ID_role,
ID_user
);

/*==============================================================*/
/* Table: Network_device                                        */
/*==============================================================*/
create table Network_device (
   ID_device            SERIAL               not null,
   IP_address           VARCHAR(64)          null,
   Type_device          VARCHAR(64)          not null,
   Mac_address          VARCHAR(17)          not null,
   constraint PK_NETWORK_DEVICE primary key (ID_device)
);

/*==============================================================*/
/* Index: Network_device_PK                                     */
/*==============================================================*/
create unique index Network_device_PK on Network_device (
ID_device
);

/*==============================================================*/
/* Table: Role                                                  */
/*==============================================================*/
create table Role (
   ID_role              SERIAL               not null,
   Name_role            VARCHAR(32)          not null,
   Desc_access          TEXT                 not null,
   constraint PK_ROLE primary key (ID_role)
);

/*==============================================================*/
/* Index: Role_PK                                               */
/*==============================================================*/
create unique index Role_PK on Role (
ID_role
);

/*==============================================================*/
/* Table: Service_activation                                    */
/*==============================================================*/
create table Service_activation (
   ID_role              INT4                 not null,
   ID_user              INT4                 not null,
   ID_connection        SERIAL               not null,
   ID_services          INT4                 not null,
   Date_connection      DATE                 not null,
   Date_disconnection   DATE                 not null,
   Name_guest           VARCHAR(128)         not null,
   Email_guest          VARCHAR(128)         not null,
   Address_connection   VARCHAR(256)         null,
   constraint PK_SERVICE_ACTIVATION primary key (ID_role, ID_user, ID_connection)
);

/*==============================================================*/
/* Index: Service_activation_PK                                 */
/*==============================================================*/
create unique index Service_activation_PK on Service_activation (
ID_role,
ID_user,
ID_connection
);

/*==============================================================*/
/* Index: Formalize_FK                                          */
/*==============================================================*/
create  index Formalize_FK on Service_activation (
ID_role,
ID_user
);

/*==============================================================*/
/* Index: Includes_FK                                           */
/*==============================================================*/
create  index Includes_FK on Service_activation (
ID_services
);

/*==============================================================*/
/* Table: Services                                              */
/*==============================================================*/
create table Services (
   ID_services          SERIAL               not null,
   Tariff_price         DECIMAL              not null,
   Description_services VARCHAR(256)         not null,
   type_services        VARCHAR(64)          not null,
   constraint PK_SERVICES primary key (ID_services)
);

/*==============================================================*/
/* Index: Services_PK                                           */
/*==============================================================*/
create unique index Services_PK on Services (
ID_services
);

/*==============================================================*/
/* Table: "User"                                                */
/*==============================================================*/
create table "User" (
   ID_role              INT4                 not null,
   ID_user              SERIAL               not null,
   FIO                  VARCHAR(128)         not null,
   Email                VARCHAR(128)         not null,
   Hash_password        TEXT                 not null,
   constraint PK_USER primary key (ID_role, ID_user)
);

/*==============================================================*/
/* Index: User_PK                                               */
/*==============================================================*/
create unique index User_PK on "User" (
ID_role,
ID_user
);

/*==============================================================*/
/* Index: Has_unique_FK                                         */
/*==============================================================*/
create  index Has_unique_FK on "User" (
ID_role
);

/*==============================================================*/
/* Table: User_request                                          */
/*==============================================================*/
create table User_request (
   ID_role              INT4                 not null,
   ID_user              INT4                 not null,
   ID_request           SERIAL               not null,
   Type_request         VARCHAR(32)          not null,
   Date_request         DATE                 not null,
   Status_review        BOOL                 not null,
   constraint PK_USER_REQUEST primary key (ID_role, ID_user, ID_request)
);

/*==============================================================*/
/* Index: User_request_PK                                       */
/*==============================================================*/
create unique index User_request_PK on User_request (
ID_role,
ID_user,
ID_request
);

/*==============================================================*/
/* Index: Leaves_FK                                             */
/*==============================================================*/
create  index Leaves_FK on User_request (
ID_role,
ID_user
);

alter table Error
   add constraint FK_ERROR_OCCURS_ON_NETWORK_ foreign key (ID_device)
      references Network_device (ID_device)
      on delete restrict on update restrict;

alter table Error
   add constraint FK_ERROR_PROCESSES_USER foreign key (ID_role, ID_user)
      references "User" (ID_role, ID_user)
      on delete restrict on update restrict;

alter table Implements
   add constraint FK_IMPLEMEN_IMPLEMENT_SERVICES foreign key (ID_services)
      references Services (ID_services)
      on delete restrict on update restrict;

alter table Implements
   add constraint FK_IMPLEMEN_IMPLEMENT_NETWORK_ foreign key (ID_device)
      references Network_device (ID_device)
      on delete restrict on update restrict;

alter table Invoice
   add constraint FK_INVOICE_FORMS_SERVICE_ foreign key (ID_role, ID_user, ID_connection)
      references Service_activation (ID_role, ID_user, ID_connection)
      on delete restrict on update restrict;

alter table Message
   add constraint FK_MESSAGE_WRITES_USER foreign key (ID_role, ID_user)
      references "User" (ID_role, ID_user)
      on delete restrict on update restrict;

alter table Service_activation
   add constraint FK_SERVICE__FORMALIZE_USER foreign key (ID_role, ID_user)
      references "User" (ID_role, ID_user)
      on delete restrict on update restrict;

alter table Service_activation
   add constraint FK_SERVICE__INCLUDES_SERVICES foreign key (ID_services)
      references Services (ID_services)
      on delete restrict on update restrict;

alter table "User"
   add constraint FK_USER_HAS_UNIQU_ROLE foreign key (ID_role)
      references Role (ID_role)
      on delete restrict on update restrict;

alter table User_request
   add constraint FK_USER_REQ_LEAVES_USER foreign key (ID_role, ID_user)
      references "User" (ID_role, ID_user)
      on delete restrict on update restrict;

