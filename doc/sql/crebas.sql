/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2015/5/11 22:32:04                           */
/*==============================================================*/


drop table if exists bns_Withdraw;

drop table if exists bns_account;

drop table if exists bns_agent;

drop table if exists bns_bank;

drop table if exists bns_bonus;

drop table if exists bns_client;

drop table if exists bns_game;

drop table if exists bns_gamelog;

drop table if exists bns_gamelogfile;

drop table if exists bns_gametype;

drop table if exists bns_loading;

drop table if exists bns_logfile;

drop table if exists bns_playmethod;

drop table if exists bns_privilege;

drop table if exists bns_systemaccount;

drop table if exists bns_tcchange;

drop table if exists bns_xtchange;

drop table if exists bns_yxchange;

drop table if exists levels;

drop table if exists sys_announcement;

drop table if exists sys_book;

drop table if exists sys_booktype;

drop table if exists sys_logfile;

drop table if exists sys_module;

drop table if exists sys_role;

drop table if exists sys_role_module;

drop table if exists sys_user;

drop table if exists sys_user_role;

/*==============================================================*/
/* Table: bns_Withdraw                                          */
/*==============================================================*/
create table bns_Withdraw
(
   Withdraw_id          int not null auto_increment,
   client_id            int not null comment '�˻�id',
   client_logname       varchar(10) not null comment '�˻�����',
   Withdraw_account_id  varchar(20) comment '���ж�����',
   Withdraw_shordernum  varchar(20) comment '�̻�������',
   Withdraw_amount      decimal not null default 0.00 comment '���ֽ��',
   Withdraw_date        timestamp not null comment '����ʱ��',
   account_id           int not null comment '����Ǯ��id',
   Withdraw_bankaccount varchar(19) not null comment '�����������п���',
   Withdraw_bankacname  varchar(6) not null comment '���������˻���',
   Withdraw_fkstate     int not null default 0 comment '���״̬ 0����1ȡ��2ͨ��3�ܾ�4�ʽ���',
   Withdraw_fkdate      timestamp not null comment '��ش���ʱ��',
   Withdraw_shuser      int comment '�����',
   Withdraw_remarks     varchar(30) comment '��ע',
   Withdraw_cnuser      int comment '����Ա',
   Withdraw_cndate      timestamp comment '�������ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (Withdraw_id)
);

/*==============================================================*/
/* Table: bns_account                                           */
/*==============================================================*/
create table bns_account
(
   account_id           int not null auto_increment comment 'ID',
   client_id            int not null comment '�˻�id',
   account_Paymethod    varchar(10) not null comment '֧��ƽ̨,�ֵ��'' Paymethod''',
   bank_id              int comment '����id',
   account_bankaccount  varchar(19) comment '�����˺ţ�������֧���ţ�',
   account_bkatowner    varchar(6) comment '�����˻���',
   account_adress       varchar(12) comment '�����е�ַ',
   account_status       int not null default 0 comment '״̬0���� 1��ͣ ',
   account_statustime   timestamp not null comment '״̬����',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (account_id)
);

/*==============================================================*/
/* Table: bns_agent                                             */
/*==============================================================*/
create table bns_agent
(
   client_id            int not null comment '�˻�D',
   agent_id             int not null comment '�ϼ�����ID',
   client_name          int not null comment '�ϼ���������'
);

/*==============================================================*/
/* Table: bns_bank                                              */
/*==============================================================*/
create table bns_bank
(
   bank_id              int not null auto_increment comment '����id',
   bank_name            varchar(10) not null comment '��������',
   bank_logo            varchar(30) comment '����logo',
   bank_status          int not null default 0 comment '״̬0����1����',
   sysuser_statustime   timestamp comment '״̬����',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (bank_id)
);

/*==============================================================*/
/* Table: bns_bonus                                             */
/*==============================================================*/
create table bns_bonus
(
   bonus_id             int not null auto_increment comment 'id',
   privilege_id         int not null comment '�Ż�',
   client_id            int not null comment '�˻�id',
   client_logname       varchar(10) not null comment '�˻���',
   bonus_entering       int comment '¼����id',
   loading_id           int comment '��ֵ����id',
   bonus_amount         decimal not null comment '���',
   bonus_apply          varchar(30) not null comment '��������',
   bonus_tjtime         timestamp not null comment '�ύʱ��',
   bonus_auditorid      int comment '�����id',
   bonus_status         int not null default 0 comment '״̬0�����1ͨ�� 2 �ܾ�',
   bonus_shtime         timestamp comment '���ʱ��',
   bonus_shdesc         varchar(30) comment '��˱�ע',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (bonus_id)
);

/*==============================================================*/
/* Table: bns_client                                            */
/*==============================================================*/
create table bns_client
(
   client_id            int not null auto_increment comment 'id',
   client_logname       varchar(10) not null comment '��¼��',
   client_pw            varchar(20) comment '��¼����',
   client_txpw          varchar(20) comment '�������루�������½���벻ͬ��',
   client_name          varchar(10) not null comment '�˻���ʵ����',
   client_nickname      varchar(6) comment '�ǳ�',
   client_sex           varchar(1) not null default '0' comment '�Ա�0��1Ů',
   client_mobile        varchar(15) not null comment '�ֻ�',
   client_email         varchar(15) not null comment '��������',
   client_remarks       varchar(30) comment '��ע',
   client_QQnum         varchar(10) comment 'QQ����',
   levels_id            int not null default 1 comment '�ȼ�',
   client_score         int not null default 0 comment '����',
   client_scoreTotal    int not null default 0 comment '�ܻ���',
   client_type          int not null comment '�ͻ�����0�Ǵ���1����2�ܴ�',
   client_ctime         timestamp not null comment 'ע������',
   client_status        int not null default 0 comment '״̬0���� 1���� ',
   client_statustime    timestamp comment '״̬����',
   client_isregister    int not null default 0 comment '�Ƿ���Կ���0��1��',
   client_khfreeze      int default 0 comment '�������',
   client_balance       decimal not null default 0.00 comment '�˻��ʽ�',
   client_freeze        decimal not null default 0.00 comment '�����ʽ�',
   client_quota         decimal default 0.00 comment '�޶�',
   client_ip            varchar(14) not null comment 'ip��ַ',
   client_mac           varchar(20) not null comment '�豸���',
   client_fandian       int comment '����',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (client_id),
   unique key AK_uniq_name (client_logname)
);

/*==============================================================*/
/* Table: bns_game                                              */
/*==============================================================*/
create table bns_game
(
   game_id              int not null auto_increment comment 'id',
   game_code            varchar(8) not null comment '��Ϸ����',
   game_name            varchar(10) not null comment '��Ϸ����',
   game_remaks          varchar(30) comment '��Ϸ��ע',
   game_status          int not null default 0 comment '״̬0���� 1��ͣ 2����',
   game_statustime      timestamp comment '״̬����',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (game_id)
);

/*==============================================================*/
/* Table: bns_gamelog                                           */
/*==============================================================*/
create table bns_gamelog
(
   gamelog_id           int not null auto_increment,
   client_id            int not null comment 'id',
   game_id              int not null comment '��Ϸid',
   playmethod_id        int not null comment '�淨id',
   gametype_id          int not null comment 'ģʽid',
   gamelog_ordernum     varchar(24) not null comment 'ע�����',
   gamelog_issue        varchar(14) not null comment '�ں�',
   gamelog_time         timestamp not null comment 'Ͷעʱ��',
   gamelog_content      varchar(15) not null comment 'Ͷע����',
   gamelog_multiply     int not null comment 'Ͷע����',
   gamelog_amount       decimal not null comment 'Ͷע�ܽ��',
   gamelog_bonus        decimal not null comment '����',
   gamelog_numbers      varchar(14) not null comment '�н�����',
   gamelog_state        int not null comment '״̬ 0Ͷע�ɹ�1Ͷעʧ��2δ����3�н�4δ�н�',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (gamelog_id)
);

/*==============================================================*/
/* Table: bns_gamelogfile                                       */
/*==============================================================*/
create table bns_gamelogfile
(
   gamelogfile_id       int not null auto_increment,
   client_id            int not null comment '�˻�id',
   game_id              int not null comment '��Ϸid',
   gamelogfile_title    varchar(10) not null comment '��־����',
   gamelogfile_pt       varchar(6) not null comment '��Ϸƽ̨����',
   gamelogfile_ip       varchar(14) comment '��Ϸip��ַ',
   gamelogfile_time     timestamp not null comment '��½ʱ��',
   gamelogfile_state    int not null comment '״̬0�ɹ�1ʧ��',
   gamelogfile_resultcode varchar(20) comment 'ʧ��ԭ��code',
   gamelogfile_remarks  varchar(30) comment '��ע',
   primary key (gamelogfile_id)
);

/*==============================================================*/
/* Table: bns_gametype                                          */
/*==============================================================*/
create table bns_gametype
(
   gametype_id          int not null auto_increment comment 'id',
   game_id              int not null comment 'id',
   gametype_name        varchar(4) not null comment 'ģʽ����',
   gametype_remarks     varchar(30) comment 'ģʽ����',
   gametype_status      int not null default 0 comment '״̬0���� 1��ͣ 2����',
   gametype_statustime  timestamp comment '״̬����',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (gametype_id)
);

/*==============================================================*/
/* Table: bns_loading                                           */
/*==============================================================*/
create table bns_loading
(
   loading_id           int not null,
   client_id            int not null comment '�˻�id',
   client_logname       varchar(10) not null comment '�˻���',
   loading_yhordernum   varchar(20) comment '���ж�����',
   loading_shordernum   varchar(20) comment '�̻�������',
   loading_amount       decimal not null default 0.00 comment '��ֵ���',
   loading_date         timestamp not null comment '��ֵ�ύʱ��',
   loading_bankid       varchar(10) not null comment '�տ�����id',
   loading_czaccount    varchar(19) not null comment '�տ������˻���',
   loading_czbankacname varchar(6) not null comment '�տ������˻�����',
   loading_ps           varchar(30) not null comment '����',
   loading_fkstate      int not null default 0 comment '״̬ 0�����1ʧ��2�ɹ�',
   loading_shuser       int comment '�����',
   loading_remarks      varchar(30) not null comment '������',
   loading_bonus        int not null default 0 comment '����0δ����1������2ͨ��3ʧ��',
   loading_bonusdesc    varchar(30) comment '���˵��',
   loading_fkdate       timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (loading_id)
);

/*==============================================================*/
/* Table: bns_logfile                                           */
/*==============================================================*/
create table bns_logfile
(
   logfile_id           int not null auto_increment comment 'id',
   client_id            int not null comment '��¼��id',
   logfile_logn         varchar(10) not null comment '��¼��',
   logfile_ip           varchar(15) not null comment 'ip��ַ',
   logfile_mac          varchar(20) not null comment '�豸���',
   logfile_logdate      datetime not null comment '��½ʱ��',
   logfile_isOnLine     int not null comment '�Ƿ�����0����1�˳�',
   logfile_desc         varchar(30) comment '����',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (logfile_id)
);

/*==============================================================*/
/* Table: bns_playmethod                                        */
/*==============================================================*/
create table bns_playmethod
(
   playmethod_id        int not null auto_increment,
   game_id              int not null comment 'id',
   playmethod_name      varchar(8) not null comment '�淨����',
   playmethod_remarks   varchar(30) comment '�淨����',
   playmethod_status    int not null default 0 comment '״̬0���� 1��ͣ 2����',
   playmethod_statustime timestamp comment '״̬����',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (playmethod_id)
);

/*==============================================================*/
/* Table: bns_privilege                                         */
/*==============================================================*/
create table bns_privilege
(
   privilege_id         int not null auto_increment,
   privilege_type       int not null comment '�Ż�����0��ˮ1����',
   privilege_name       varchar(12) not null comment '�Żݱ���',
   privilege_loadamount2 decimal default 0.00 comment '��ֵ����Ϸ������',
   privilege_loadamount1 decimal default 0.00 comment '��ֵ����Ϸ������',
   privilege_awardamount decimal default 0.00 comment '�����̶����',
   privilege_desc       varchar(30) not null comment '�Ż�˵��',
   privilege_ratio      numeric(4,0) comment '��ˮ����',
   privilege_fbtime     timestamp not null comment '��������',
   privilege_status     int not null default 0 comment '״̬0���� 1��ͣ 2����',
   privilege_statustime timestamp not null comment '״̬����',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   primary key (privilege_id)
);

/*==============================================================*/
/* Table: bns_systemaccount                                     */
/*==============================================================*/
create table bns_systemaccount
(
   systemaccount_id     int not null auto_increment comment 'ID',
   systemaccount_Paymethod varchar(10) not null comment '֧��ƽ̨,�ֵ��'' Paymethod''',
   bank_id              int comment '����id',
   systemaccount_bankaccount varchar(19) comment '�����˺ţ�������֧���ţ�',
   systemaccount_bkatowner varchar(6) comment '�����˻���',
   systemaccount_adress varchar(12) comment '�����е�ַ',
   systemaccount_status int not null default 0 comment '״̬0���� 1��ͣ ',
   systemaccount_statustime timestamp not null comment '״̬����',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (systemaccount_id)
);

/*==============================================================*/
/* Table: bns_tcchange                                          */
/*==============================================================*/
create table bns_tcchange
(
   tcchange_id          int not null auto_increment comment 'id',
   client_id            int not null comment '�˻�id',
   client_logname       varchar(10) not null comment '�˻���',
   tcchange_ordernum    varchar(20) not null comment '������',
   tcchange_type        int not null comment '�˱�����0��ֵ1����',
   tcchange_amount      decimal not null default 0.00 comment '�˱���',
   tcchange_balance1    decimal not null default 0.00 comment '�˱�ǰ���',
   tcchange_balance2    decimal not null default 0.00 comment '�˱�����',
   tcchange_desc        varchar(30) comment '��ע',
   czdate               timestamp not null comment '�˱�ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   tcchange_freeze      decimal not null default 0.00 comment '�����ʽ�',
   primary key (tcchange_id)
);

/*==============================================================*/
/* Table: bns_xtchange                                          */
/*==============================================================*/
create table bns_xtchange
(
   xtchange_id          int not null auto_increment comment 'id',
   systemaccount_id     int comment 'ϵͳǮ��id',
   account_id           int not null comment 'Ǯ��id',
   tcchange_ordernum    varchar(20) not null comment '������',
   tcchange_type        int not null comment '�˱�����0����1֧��',
   tcchange_amount      decimal not null default 0.00 comment '�˱���',
   tcchange_desc        varchar(30) comment '��ע',
   czdate               timestamp not null default 'sysdate' comment '�˱�ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (xtchange_id)
);

/*==============================================================*/
/* Table: bns_yxchange                                          */
/*==============================================================*/
create table bns_yxchange
(
   yxchange_id          int not null auto_increment comment 'id',
   yxchange_type        int not null comment '����0��Ϸ��ֵ1��ϷͶע2����3��ֵ',
   game_id              int comment '��Ϸid',
   bonus_id             int comment '������id',
   client_id            int not null comment '�˻�id',
   client_logname       varchar(10) not null comment '�˻���',
   yxchange_amount      decimal not null comment 'ת�˽��',
   yxchange_yxbalance1  decimal not null default 0.00 comment '��Ϸת��ǰ�������',
   yxchange_yxbalance2  decimal not null default 0.00 comment '��Ϸת�˺�������',
   yxchange_zhbalance1  decimal not null default 0.00 comment '�˻�ת��ǰ�������',
   yxchange_zhbalance2  decimal not null default 0.00 comment '�˻�ת�˺�������',
   yxchange_freeze      decimal not null default 0.00 comment '�����ʽ�',
   yxchange_desc        varchar(30) comment '��ע',
   yxchange_date        timestamp not null comment '�˱�ʱ��',
   yxchange_result      int default 0 comment '�˱���0������1�ɹ�2ʧ��',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (yxchange_id)
);

/*==============================================================*/
/* Table: levels                                                */
/*==============================================================*/
create table levels
(
   levels_id            int not null comment '�û��ȼ�',
   level                int not null comment '����',
   level_Name           varchar(4) not null comment '����˵��',
   levels_minscore      int not null comment '�ܻ�������',
   levels_maxscore      int not null comment '�ܻ�������',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (levels_id)
);

/*==============================================================*/
/* Table: sys_announcement                                      */
/*==============================================================*/
create table sys_announcement
(
   announcement_id      int not null auto_increment,
   sysuser_id           int not null comment 'id',
   sysuser_logn         varchar(10) not null comment '������',
   announcement_title   varchar(20) not null comment '�������',
   announcement_text    varchar(50) not null comment '��������',
   announcement_date    timestamp not null comment '�ύ���޸�ʱ��',
   announcement_checkuser int comment '�����',
   announcement_state   int not null default 0 comment '״̬0δ���1����2�ܾ�',
   announcement_shdate  timestamp not null comment '״̬ʱ��',
   announcement_first   int not null default 0 comment '0���ö�1�ö�',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (announcement_id)
);

/*==============================================================*/
/* Table: sys_book                                              */
/*==============================================================*/
create table sys_book
(
   id                   int not null auto_increment,
   booktype_code        varchar(10) not null comment '�ֵ�����code',
   sys_book_no          varchar(10) not null comment '�ֵ����',
   sys_book_value       varchar(10) not null comment '�ֵ�ֵ',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (id),
   unique key AK_uniq_book_no (sys_book_no)
);

/*==============================================================*/
/* Table: sys_booktype                                          */
/*==============================================================*/
create table sys_booktype
(
   id                   int not null auto_increment comment 'ϵͳ�ֵ�����',
   sys_booktype_name    varchar(10) not null comment '�ֵ�����',
   sys_booktype_code    varchar(10) not null comment '�ֵ����ͱ���',
   sys_booktype_desc    varchar(30) comment '��ע',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (id),
   unique key AK_uniq_bookcode (sys_booktype_code)
);

/*==============================================================*/
/* Table: sys_logfile                                           */
/*==============================================================*/
create table sys_logfile
(
   id                   int not null auto_increment comment 'id',
   sysuser_id           int not null comment '��¼��id',
   sys_logfile_logn     varchar(10) not null comment '��¼��',
   sys_logfile_ip       varchar(20) comment 'ip��ַ',
   sys_logfile_logdate  timestamp not null comment '��½ʱ��',
   sys_logfile_isonline int not null default 0 comment '�Ƿ�����0����1�˳�',
   sys_logfile_esctime  timestamp comment '�˳�ʱ��',
   sys_logfile_desc     varchar(30) comment '����',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (id)
);

/*==============================================================*/
/* Table: sys_module                                            */
/*==============================================================*/
create table sys_module
(
   id                   int not null auto_increment comment 'id',
   sys_module_pid       int not null comment '������id',
   sys_module_name      varchar(10) not null comment 'ģ������',
   sys_module_url       varchar(20) not null comment '���ӵ�ַ',
   sys_module_icon      varchar(20) comment 'ͼ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   primary key (id)
);

/*==============================================================*/
/* Table: sys_role                                              */
/*==============================================================*/
create table sys_role
(
   id                   int not null auto_increment comment 'id',
   sys_rolename         varchar(10) not null comment 'Ȩ��������',
   sys_role_desc        varchar(30) comment '��ע',
   sysuser_id           int not null default 0 comment '������',
   czdate               timestamp not null comment '����ʱ��',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (id)
);

/*==============================================================*/
/* Table: sys_role_module                                       */
/*==============================================================*/
create table sys_role_module
(
   id                   int not null auto_increment comment 'id',
   role_id              int not null comment '��ɫid',
   module_id            int comment 'id',
   primary key (id)
);

/*==============================================================*/
/* Table: sys_user                                              */
/*==============================================================*/
create table sys_user
(
   id                   int not null auto_increment comment 'id',
   sys_user_logn        varchar(10) not null comment '��¼��',
   sys_user_pw          varchar(20) not null comment '��¼����',
   sys_user_name        varchar(15) comment '�ǳ�',
   sys_user_sex         int not null default 0 comment '�Ա�0 �� 1 Ů',
   sys_user_birthday    date comment '����',
   sys_user_adress      varchar(20) comment '��ַ',
   sys_user_mobile      varchar(15) not null comment '�ֻ�',
   sys_user_email       varchar(15) not null comment '��������',
   sys_user_QQnum       varchar(15) comment 'QQ����',
   sys_user_ip          varchar(14) comment '��½ip',
   sys_user_remarks     varchar(30) comment '��ע',
   sys_user_createdate  datetime not null comment '��������',
   sys_user_status      int not null default 0 comment '״̬0���� 1��ͣ 2����',
   sys_user_statustime  timestamp comment '״̬����',
   isdelete             int not null default 0 comment '�Ƿ�ɾ��',
   primary key (id),
   unique key AK_uniq_logname (sys_user_logn)
);

/*==============================================================*/
/* Table: sys_user_role                                         */
/*==============================================================*/
create table sys_user_role
(
   useroleid            int not null auto_increment comment 'id',
   sysuser_id           int comment 'id',
   role_id              int comment 'id',
   primary key (useroleid)
);

alter table bns_Withdraw add constraint FK_client_Withdraw foreign key (client_id)
      references bns_client (client_id) on delete restrict on update restrict;

alter table bns_account add constraint FK_bank_account foreign key (bank_id)
      references bns_bank (bank_id) on delete restrict on update restrict;

alter table bns_account add constraint FK_client_account foreign key (client_id)
      references bns_client (client_id) on delete restrict on update restrict;

alter table bns_agent add constraint FK_agent_client foreign key (client_id)
      references bns_client (client_id) on delete restrict on update restrict;

alter table bns_bonus add constraint FK_client_bonus foreign key (client_id)
      references bns_client (client_id) on delete restrict on update restrict;

alter table bns_bonus add constraint FK_privilege_bonus foreign key (privilege_id)
      references bns_privilege (privilege_id) on delete restrict on update restrict;

alter table bns_client add constraint FK_Reference_26 foreign key (levels_id)
      references levels (levels_id) on delete restrict on update restrict;

alter table bns_gamelog add constraint FK_Reference_20 foreign key (gametype_id)
      references bns_gametype (gametype_id) on delete restrict on update restrict;

alter table bns_gamelog add constraint FK_Reference_21 foreign key (playmethod_id)
      references bns_playmethod (playmethod_id) on delete restrict on update restrict;

alter table bns_gamelog add constraint FK_game_gamelog foreign key (game_id)
      references bns_game (game_id) on delete restrict on update restrict;

alter table bns_gamelogfile add constraint FK_client_gamelogfile foreign key (client_id)
      references bns_client (client_id) on delete restrict on update restrict;

alter table bns_gamelogfile add constraint FK_game_gamelogfile foreign key (game_id)
      references bns_game (game_id) on delete restrict on update restrict;

alter table bns_gametype add constraint FK_game_gametype foreign key (game_id)
      references bns_game (game_id) on delete restrict on update restrict;

alter table bns_loading add constraint FK_Reference_29 foreign key (loading_bankid)
      references bns_systemaccount (systemaccount_id) on delete restrict on update restrict;

alter table bns_loading add constraint FK_client_loading foreign key (client_id)
      references bns_client (client_id) on delete restrict on update restrict;

alter table bns_playmethod add constraint FK_game_playmethod foreign key (game_id)
      references bns_game (game_id) on delete restrict on update restrict;

alter table bns_systemaccount add constraint FK_Reference_27 foreign key (bank_id)
      references bns_bank (bank_id) on delete restrict on update restrict;

alter table bns_tcchange add constraint FK_client_tcchange foreign key (client_id)
      references bns_client (client_id) on delete restrict on update restrict;

alter table bns_xtchange add constraint FK_Reference_28 foreign key (systemaccount_id)
      references bns_systemaccount (systemaccount_id) on delete restrict on update restrict;

alter table bns_yxchange add constraint FK_client_yxchange foreign key (client_id)
      references bns_client (client_id) on delete restrict on update restrict;

alter table bns_yxchange add constraint FK_game_yxchange foreign key (game_id)
      references bns_game (game_id) on delete restrict on update restrict;

alter table sys_announcement add constraint FK_Reference_25 foreign key (sysuser_id)
      references sys_user (id) on delete restrict on update restrict;

alter table sys_book add constraint FK_book_booktype foreign key (booktype_code)
      references sys_booktype (id) on delete restrict on update restrict;

alter table sys_role_module add constraint FK_role_module1 foreign key (role_id)
      references sys_role (id) on delete restrict on update restrict;

alter table sys_role_module add constraint FK_role_module2 foreign key (module_id)
      references sys_module (id) on delete restrict on update restrict;

alter table sys_user_role add constraint FK_user_role1 foreign key (sysuser_id)
      references sys_user (id) on delete restrict on update restrict;

alter table sys_user_role add constraint FK_user_role2 foreign key (role_id)
      references sys_role (id) on delete restrict on update restrict;

