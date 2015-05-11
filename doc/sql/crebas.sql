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
   client_id            int not null comment '账户id',
   client_logname       varchar(10) not null comment '账户名称',
   Withdraw_account_id  varchar(20) comment '银行订单号',
   Withdraw_shordernum  varchar(20) comment '商户订单号',
   Withdraw_amount      decimal not null default 0.00 comment '提现金额',
   Withdraw_date        timestamp not null comment '发起时间',
   account_id           int not null comment '提现钱包id',
   Withdraw_bankaccount varchar(19) not null comment '提现银行银行卡号',
   Withdraw_bankacname  varchar(6) not null comment '提现银行账户名',
   Withdraw_fkstate     int not null default 0 comment '风控状态 0申请1取消2通过3拒绝4资金到账',
   Withdraw_fkdate      timestamp not null comment '风控处理时间',
   Withdraw_shuser      int comment '审核人',
   Withdraw_remarks     varchar(30) comment '备注',
   Withdraw_cnuser      int comment '出纳员',
   Withdraw_cndate      timestamp comment '交易完成时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (Withdraw_id)
);

/*==============================================================*/
/* Table: bns_account                                           */
/*==============================================================*/
create table bns_account
(
   account_id           int not null auto_increment comment 'ID',
   client_id            int not null comment '账户id',
   account_Paymethod    varchar(10) not null comment '支付平台,字典表'' Paymethod''',
   bank_id              int comment '银行id',
   account_bankaccount  varchar(19) comment '银行账号（第三方支付号）',
   account_bkatowner    varchar(6) comment '银行账户名',
   account_adress       varchar(12) comment '开户行地址',
   account_status       int not null default 0 comment '状态0正常 1暂停 ',
   account_statustime   timestamp not null comment '状态日期',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (account_id)
);

/*==============================================================*/
/* Table: bns_agent                                             */
/*==============================================================*/
create table bns_agent
(
   client_id            int not null comment '账户D',
   agent_id             int not null comment '上级代理ID',
   client_name          int not null comment '上级代理名称'
);

/*==============================================================*/
/* Table: bns_bank                                              */
/*==============================================================*/
create table bns_bank
(
   bank_id              int not null auto_increment comment '银行id',
   bank_name            varchar(10) not null comment '银行名称',
   bank_logo            varchar(30) comment '银行logo',
   bank_status          int not null default 0 comment '状态0正常1作废',
   sysuser_statustime   timestamp comment '状态日期',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (bank_id)
);

/*==============================================================*/
/* Table: bns_bonus                                             */
/*==============================================================*/
create table bns_bonus
(
   bonus_id             int not null auto_increment comment 'id',
   privilege_id         int not null comment '优惠',
   client_id            int not null comment '账户id',
   client_logname       varchar(10) not null comment '账户名',
   bonus_entering       int comment '录入人id',
   loading_id           int comment '充值申请id',
   bonus_amount         decimal not null comment '金额',
   bonus_apply          varchar(30) not null comment '申请理由',
   bonus_tjtime         timestamp not null comment '提交时间',
   bonus_auditorid      int comment '审核人id',
   bonus_status         int not null default 0 comment '状态0审核中1通过 2 拒绝',
   bonus_shtime         timestamp comment '审核时间',
   bonus_shdesc         varchar(30) comment '审核备注',
   isdelete             int not null default 0 comment '是否删除',
   primary key (bonus_id)
);

/*==============================================================*/
/* Table: bns_client                                            */
/*==============================================================*/
create table bns_client
(
   client_id            int not null auto_increment comment 'id',
   client_logname       varchar(10) not null comment '登录名',
   client_pw            varchar(20) comment '登录密码',
   client_txpw          varchar(20) comment '交易密码（必须与登陆密码不同）',
   client_name          varchar(10) not null comment '账户真实姓名',
   client_nickname      varchar(6) comment '昵称',
   client_sex           varchar(1) not null default '0' comment '性别0男1女',
   client_mobile        varchar(15) not null comment '手机',
   client_email         varchar(15) not null comment '电子邮箱',
   client_remarks       varchar(30) comment '备注',
   client_QQnum         varchar(10) comment 'QQ号码',
   levels_id            int not null default 1 comment '等级',
   client_score         int not null default 0 comment '积分',
   client_scoreTotal    int not null default 0 comment '总积分',
   client_type          int not null comment '客户类型0非代理1代理2总代',
   client_ctime         timestamp not null comment '注册日期',
   client_status        int not null default 0 comment '状态0正常 1冻结 ',
   client_statustime    timestamp comment '状态日期',
   client_isregister    int not null default 0 comment '是否可以开户0否1是',
   client_khfreeze      int default 0 comment '开户配额',
   client_balance       decimal not null default 0.00 comment '账户资金',
   client_freeze        decimal not null default 0.00 comment '冻结资金',
   client_quota         decimal default 0.00 comment '限额',
   client_ip            varchar(14) not null comment 'ip地址',
   client_mac           varchar(20) not null comment '设备序号',
   client_fandian       int comment '返点',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (client_id),
   unique key AK_uniq_name (client_logname)
);

/*==============================================================*/
/* Table: bns_game                                              */
/*==============================================================*/
create table bns_game
(
   game_id              int not null auto_increment comment 'id',
   game_code            varchar(8) not null comment '游戏编码',
   game_name            varchar(10) not null comment '游戏名称',
   game_remaks          varchar(30) comment '游戏备注',
   game_status          int not null default 0 comment '状态0正常 1暂停 2作废',
   game_statustime      timestamp comment '状态日期',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (game_id)
);

/*==============================================================*/
/* Table: bns_gamelog                                           */
/*==============================================================*/
create table bns_gamelog
(
   gamelog_id           int not null auto_increment,
   client_id            int not null comment 'id',
   game_id              int not null comment '游戏id',
   playmethod_id        int not null comment '玩法id',
   gametype_id          int not null comment '模式id',
   gamelog_ordernum     varchar(24) not null comment '注单编号',
   gamelog_issue        varchar(14) not null comment '期号',
   gamelog_time         timestamp not null comment '投注时间',
   gamelog_content      varchar(15) not null comment '投注内容',
   gamelog_multiply     int not null comment '投注倍数',
   gamelog_amount       decimal not null comment '投注总金额',
   gamelog_bonus        decimal not null comment '奖金',
   gamelog_numbers      varchar(14) not null comment '中奖号码',
   gamelog_state        int not null comment '状态 0投注成功1投注失败2未开奖3中奖4未中奖',
   isdelete             int not null default 0 comment '是否删除',
   primary key (gamelog_id)
);

/*==============================================================*/
/* Table: bns_gamelogfile                                       */
/*==============================================================*/
create table bns_gamelogfile
(
   gamelogfile_id       int not null auto_increment,
   client_id            int not null comment '账户id',
   game_id              int not null comment '游戏id',
   gamelogfile_title    varchar(10) not null comment '日志标题',
   gamelogfile_pt       varchar(6) not null comment '游戏平台名称',
   gamelogfile_ip       varchar(14) comment '游戏ip地址',
   gamelogfile_time     timestamp not null comment '登陆时间',
   gamelogfile_state    int not null comment '状态0成功1失败',
   gamelogfile_resultcode varchar(20) comment '失败原因code',
   gamelogfile_remarks  varchar(30) comment '备注',
   primary key (gamelogfile_id)
);

/*==============================================================*/
/* Table: bns_gametype                                          */
/*==============================================================*/
create table bns_gametype
(
   gametype_id          int not null auto_increment comment 'id',
   game_id              int not null comment 'id',
   gametype_name        varchar(4) not null comment '模式名称',
   gametype_remarks     varchar(30) comment '模式解释',
   gametype_status      int not null default 0 comment '状态0正常 1暂停 2作废',
   gametype_statustime  timestamp comment '状态日期',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (gametype_id)
);

/*==============================================================*/
/* Table: bns_loading                                           */
/*==============================================================*/
create table bns_loading
(
   loading_id           int not null,
   client_id            int not null comment '账户id',
   client_logname       varchar(10) not null comment '账户名',
   loading_yhordernum   varchar(20) comment '银行订单号',
   loading_shordernum   varchar(20) comment '商户订单号',
   loading_amount       decimal not null default 0.00 comment '充值金额',
   loading_date         timestamp not null comment '充值提交时间',
   loading_bankid       varchar(10) not null comment '收款银行id',
   loading_czaccount    varchar(19) not null comment '收款银行账户号',
   loading_czbankacname varchar(6) not null comment '收款银行账户名称',
   loading_ps           varchar(30) not null comment '附言',
   loading_fkstate      int not null default 0 comment '状态 0审核中1失败2成功',
   loading_shuser       int comment '审核人',
   loading_remarks      varchar(30) not null comment '审核意见',
   loading_bonus        int not null default 0 comment '红利0未申请1申请中2通过3失败',
   loading_bonusdesc    varchar(30) comment '审核说明',
   loading_fkdate       timestamp not null comment '处理时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (loading_id)
);

/*==============================================================*/
/* Table: bns_logfile                                           */
/*==============================================================*/
create table bns_logfile
(
   logfile_id           int not null auto_increment comment 'id',
   client_id            int not null comment '登录人id',
   logfile_logn         varchar(10) not null comment '登录名',
   logfile_ip           varchar(15) not null comment 'ip地址',
   logfile_mac          varchar(20) not null comment '设备序号',
   logfile_logdate      datetime not null comment '登陆时间',
   logfile_isOnLine     int not null comment '是否在线0在线1退出',
   logfile_desc         varchar(30) comment '描述',
   isdelete             int not null default 0 comment '是否删除',
   primary key (logfile_id)
);

/*==============================================================*/
/* Table: bns_playmethod                                        */
/*==============================================================*/
create table bns_playmethod
(
   playmethod_id        int not null auto_increment,
   game_id              int not null comment 'id',
   playmethod_name      varchar(8) not null comment '玩法名称',
   playmethod_remarks   varchar(30) comment '玩法解释',
   playmethod_status    int not null default 0 comment '状态0正常 1暂停 2作废',
   playmethod_statustime timestamp comment '状态日期',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (playmethod_id)
);

/*==============================================================*/
/* Table: bns_privilege                                         */
/*==============================================================*/
create table bns_privilege
(
   privilege_id         int not null auto_increment,
   privilege_type       int not null comment '优惠类型0返水1红利',
   privilege_name       varchar(12) not null comment '优惠标题',
   privilege_loadamount2 decimal default 0.00 comment '充值（游戏金额）上限',
   privilege_loadamount1 decimal default 0.00 comment '充值（游戏金额）下限',
   privilege_awardamount decimal default 0.00 comment '红利固定金额',
   privilege_desc       varchar(30) not null comment '优惠说明',
   privilege_ratio      numeric(4,0) comment '返水比例',
   privilege_fbtime     timestamp not null comment '发布日期',
   privilege_status     int not null default 0 comment '状态0正常 1暂停 2过期',
   privilege_statustime timestamp not null comment '状态日期',
   isdelete             int not null default 0 comment '是否删除',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   primary key (privilege_id)
);

/*==============================================================*/
/* Table: bns_systemaccount                                     */
/*==============================================================*/
create table bns_systemaccount
(
   systemaccount_id     int not null auto_increment comment 'ID',
   systemaccount_Paymethod varchar(10) not null comment '支付平台,字典表'' Paymethod''',
   bank_id              int comment '银行id',
   systemaccount_bankaccount varchar(19) comment '银行账号（第三方支付号）',
   systemaccount_bkatowner varchar(6) comment '银行账户名',
   systemaccount_adress varchar(12) comment '开户行地址',
   systemaccount_status int not null default 0 comment '状态0正常 1暂停 ',
   systemaccount_statustime timestamp not null comment '状态日期',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (systemaccount_id)
);

/*==============================================================*/
/* Table: bns_tcchange                                          */
/*==============================================================*/
create table bns_tcchange
(
   tcchange_id          int not null auto_increment comment 'id',
   client_id            int not null comment '账户id',
   client_logname       varchar(10) not null comment '账户名',
   tcchange_ordernum    varchar(20) not null comment '订单号',
   tcchange_type        int not null comment '账变类型0充值1提现',
   tcchange_amount      decimal not null default 0.00 comment '账变金额',
   tcchange_balance1    decimal not null default 0.00 comment '账变前余额',
   tcchange_balance2    decimal not null default 0.00 comment '账变后余额',
   tcchange_desc        varchar(30) comment '备注',
   czdate               timestamp not null comment '账变时间',
   isdelete             int not null default 0 comment '是否删除',
   tcchange_freeze      decimal not null default 0.00 comment '冻结资金',
   primary key (tcchange_id)
);

/*==============================================================*/
/* Table: bns_xtchange                                          */
/*==============================================================*/
create table bns_xtchange
(
   xtchange_id          int not null auto_increment comment 'id',
   systemaccount_id     int comment '系统钱包id',
   account_id           int not null comment '钱包id',
   tcchange_ordernum    varchar(20) not null comment '订单号',
   tcchange_type        int not null comment '账变类型0进账1支出',
   tcchange_amount      decimal not null default 0.00 comment '账变金额',
   tcchange_desc        varchar(30) comment '备注',
   czdate               timestamp not null default 'sysdate' comment '账变时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (xtchange_id)
);

/*==============================================================*/
/* Table: bns_yxchange                                          */
/*==============================================================*/
create table bns_yxchange
(
   yxchange_id          int not null auto_increment comment 'id',
   yxchange_type        int not null comment '类型0游戏充值1游戏投注2红利3充值',
   game_id              int comment '游戏id',
   bonus_id             int comment '红利表id',
   client_id            int not null comment '账户id',
   client_logname       varchar(10) not null comment '账户名',
   yxchange_amount      decimal not null comment '转账金额',
   yxchange_yxbalance1  decimal not null default 0.00 comment '游戏转账前可用余额',
   yxchange_yxbalance2  decimal not null default 0.00 comment '游戏转账后可用余额',
   yxchange_zhbalance1  decimal not null default 0.00 comment '账户转账前可用余额',
   yxchange_zhbalance2  decimal not null default 0.00 comment '账户转账后可用余额',
   yxchange_freeze      decimal not null default 0.00 comment '冻结资金',
   yxchange_desc        varchar(30) comment '备注',
   yxchange_date        timestamp not null comment '账变时间',
   yxchange_result      int default 0 comment '账变结果0处理中1成功2失败',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (yxchange_id)
);

/*==============================================================*/
/* Table: levels                                                */
/*==============================================================*/
create table levels
(
   levels_id            int not null comment '用户等级',
   level                int not null comment '数字',
   level_Name           varchar(4) not null comment '文字说明',
   levels_minscore      int not null comment '总积分下限',
   levels_maxscore      int not null comment '总积分上限',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (levels_id)
);

/*==============================================================*/
/* Table: sys_announcement                                      */
/*==============================================================*/
create table sys_announcement
(
   announcement_id      int not null auto_increment,
   sysuser_id           int not null comment 'id',
   sysuser_logn         varchar(10) not null comment '发布人',
   announcement_title   varchar(20) not null comment '公告标题',
   announcement_text    varchar(50) not null comment '公告内容',
   announcement_date    timestamp not null comment '提交或修改时间',
   announcement_checkuser int comment '审核人',
   announcement_state   int not null default 0 comment '状态0未审核1允许2拒绝',
   announcement_shdate  timestamp not null comment '状态时间',
   announcement_first   int not null default 0 comment '0非置顶1置顶',
   isdelete             int not null default 0 comment '是否删除',
   primary key (announcement_id)
);

/*==============================================================*/
/* Table: sys_book                                              */
/*==============================================================*/
create table sys_book
(
   id                   int not null auto_increment,
   booktype_code        varchar(10) not null comment '字典类型code',
   sys_book_no          varchar(10) not null comment '字典编码',
   sys_book_value       varchar(10) not null comment '字典值',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (id),
   unique key AK_uniq_book_no (sys_book_no)
);

/*==============================================================*/
/* Table: sys_booktype                                          */
/*==============================================================*/
create table sys_booktype
(
   id                   int not null auto_increment comment '系统字典类型',
   sys_booktype_name    varchar(10) not null comment '字典名称',
   sys_booktype_code    varchar(10) not null comment '字典类型编码',
   sys_booktype_desc    varchar(30) comment '备注',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (id),
   unique key AK_uniq_bookcode (sys_booktype_code)
);

/*==============================================================*/
/* Table: sys_logfile                                           */
/*==============================================================*/
create table sys_logfile
(
   id                   int not null auto_increment comment 'id',
   sysuser_id           int not null comment '登录人id',
   sys_logfile_logn     varchar(10) not null comment '登录名',
   sys_logfile_ip       varchar(20) comment 'ip地址',
   sys_logfile_logdate  timestamp not null comment '登陆时间',
   sys_logfile_isonline int not null default 0 comment '是否在线0在线1退出',
   sys_logfile_esctime  timestamp comment '退出时间',
   sys_logfile_desc     varchar(30) comment '描述',
   isdelete             int not null default 0 comment '是否删除',
   primary key (id)
);

/*==============================================================*/
/* Table: sys_module                                            */
/*==============================================================*/
create table sys_module
(
   id                   int not null auto_increment comment 'id',
   sys_module_pid       int not null comment '父界面id',
   sys_module_name      varchar(10) not null comment '模块名称',
   sys_module_url       varchar(20) not null comment '链接地址',
   sys_module_icon      varchar(20) comment '图标',
   isdelete             int not null default 0 comment '是否删除',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   primary key (id)
);

/*==============================================================*/
/* Table: sys_role                                              */
/*==============================================================*/
create table sys_role
(
   id                   int not null auto_increment comment 'id',
   sys_rolename         varchar(10) not null comment '权限组名称',
   sys_role_desc        varchar(30) comment '备注',
   sysuser_id           int not null default 0 comment '操作人',
   czdate               timestamp not null comment '操作时间',
   isdelete             int not null default 0 comment '是否删除',
   primary key (id)
);

/*==============================================================*/
/* Table: sys_role_module                                       */
/*==============================================================*/
create table sys_role_module
(
   id                   int not null auto_increment comment 'id',
   role_id              int not null comment '角色id',
   module_id            int comment 'id',
   primary key (id)
);

/*==============================================================*/
/* Table: sys_user                                              */
/*==============================================================*/
create table sys_user
(
   id                   int not null auto_increment comment 'id',
   sys_user_logn        varchar(10) not null comment '登录名',
   sys_user_pw          varchar(20) not null comment '登录密码',
   sys_user_name        varchar(15) comment '昵称',
   sys_user_sex         int not null default 0 comment '性别0 男 1 女',
   sys_user_birthday    date comment '生日',
   sys_user_adress      varchar(20) comment '地址',
   sys_user_mobile      varchar(15) not null comment '手机',
   sys_user_email       varchar(15) not null comment '电子邮箱',
   sys_user_QQnum       varchar(15) comment 'QQ号码',
   sys_user_ip          varchar(14) comment '登陆ip',
   sys_user_remarks     varchar(30) comment '备注',
   sys_user_createdate  datetime not null comment '创建日期',
   sys_user_status      int not null default 0 comment '状态0正常 1暂停 2作废',
   sys_user_statustime  timestamp comment '状态日期',
   isdelete             int not null default 0 comment '是否删除',
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

