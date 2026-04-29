# The proper term is pseudo_replica_mode, but we use this compatibility alias
# to make the statement usable on server versions 8.0.24 and older.
/*!50530 SET @@SESSION.PSEUDO_SLAVE_MODE=1*/;
/*!50003 SET @OLD_COMPLETION_TYPE=@@COMPLETION_TYPE,COMPLETION_TYPE=0*/;
DELIMITER /*!*/;
# at 4
#260414  0:47:38 server id 1  end_log_pos 127 CRC32 0xfc675d57 	Start: binlog v 4, server v 8.4.7 created 260414  0:47:38 at startup
# Warning: this binlog is either in use or was not closed properly.
ROLLBACK/*!*/;
# at 127
#260414  0:47:38 server id 1  end_log_pos 158 CRC32 0x81ce53c8 	Previous-GTIDs
# [empty]
# at 158
#260414  8:08:25 server id 1  end_log_pos 237 CRC32 0x7b3556dc 	Anonymous_GTID	last_committed=0	sequence_number=1	rbr_only=yes	original_committed_timestamp=1776164905433247	immediate_commit_timestamp=1776164905433247	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776164905433247 (2026-04-14 08:08:25.433247 Hora oficial do Brasil)
# immediate_commit_timestamp=1776164905433247 (2026-04-14 08:08:25.433247 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776164905433247*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 237
#260414  8:08:25 server id 1  end_log_pos 332 CRC32 0xe172a5e8 	Query	thread_id=12	exec_time=0	error_code=0
SET TIMESTAMP=1776164905/*!*/;
SET @@session.pseudo_thread_id=12/*!*/;
SET @@session.foreign_key_checks=1, @@session.sql_auto_is_null=0, @@session.unique_checks=1, @@session.autocommit=1/*!*/;
SET @@session.sql_mode=1168113696/*!*/;
SET @@session.auto_increment_increment=1, @@session.auto_increment_offset=1/*!*/;
/*!\C utf8mb4 *//*!*/;
SET @@session.character_set_client=224,@@session.collation_connection=224,@@session.collation_server=255/*!*/;
SET @@session.time_zone='SYSTEM'/*!*/;
SET @@session.lc_time_names=0/*!*/;
SET @@session.collation_database=DEFAULT/*!*/;
/*!80011 SET @@session.default_collation_for_utf8mb4=255*//*!*/;
BEGIN
/*!*/;
# at 332
#260414  8:08:25 server id 1  end_log_pos 424 CRC32 0x65988d4d 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 424
#260414  8:08:25 server id 1  end_log_pos 627 CRC32 0x34b3866d 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=844
###   @2=1247
###   @3='Venda realizada - Coleta #1186'
###   @4=118.00
###   @5='2026:04:14'
###   @6=NULL
###   @7='2026:04:13'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086054
###   @13=1776086054
### SET
###   @1=844
###   @2=1247
###   @3='Venda realizada - Coleta #1186'
###   @4=118.00
###   @5='2026:04:14'
###   @6='2026:04:14'
###   @7='2026:04:13'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086054
###   @13=1776175705
# at 627
#260414  8:08:25 server id 1  end_log_pos 712 CRC32 0xf7685a31 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 712
#260414  8:08:25 server id 1  end_log_pos 829 CRC32 0xb2ff0d48 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=795
###   @2='2026:04:14'
###   @3=1
###   @4=118.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #844'
###   @8=844
###   @9=1776175705
###   @10=1776175705
# at 829
#260414  8:08:25 server id 1  end_log_pos 860 CRC32 0x1865b60b 	Xid = 69
COMMIT/*!*/;
# at 860
#260414  8:08:34 server id 1  end_log_pos 939 CRC32 0xf5da6f8d 	Anonymous_GTID	last_committed=1	sequence_number=2	rbr_only=yes	original_committed_timestamp=1776164914211751	immediate_commit_timestamp=1776164914211751	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776164914211751 (2026-04-14 08:08:34.211751 Hora oficial do Brasil)
# immediate_commit_timestamp=1776164914211751 (2026-04-14 08:08:34.211751 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776164914211751*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 939
#260414  8:08:34 server id 1  end_log_pos 1034 CRC32 0x995d2a0f 	Query	thread_id=15	exec_time=0	error_code=0
SET TIMESTAMP=1776164914/*!*/;
BEGIN
/*!*/;
# at 1034
#260414  8:08:34 server id 1  end_log_pos 1126 CRC32 0x29301285 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 1126
#260414  8:08:34 server id 1  end_log_pos 1329 CRC32 0x05388db2 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=845
###   @2=1521
###   @3='Venda realizada - Coleta #1187'
###   @4=38.91
###   @5='2026:04:14'
###   @6=NULL
###   @7='2026:04:13'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086087
###   @13=1776087798
### SET
###   @1=845
###   @2=1521
###   @3='Venda realizada - Coleta #1187'
###   @4=38.91
###   @5='2026:04:14'
###   @6='2026:04:14'
###   @7='2026:04:13'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086087
###   @13=1776175714
# at 1329
#260414  8:08:34 server id 1  end_log_pos 1414 CRC32 0xdeea73c8 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 1414
#260414  8:08:34 server id 1  end_log_pos 1531 CRC32 0x7240913e 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=796
###   @2='2026:04:14'
###   @3=1
###   @4=38.91
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #845'
###   @8=845
###   @9=1776175714
###   @10=1776175714
# at 1531
#260414  8:08:34 server id 1  end_log_pos 1562 CRC32 0xda34baa0 	Xid = 116
COMMIT/*!*/;
# at 1562
#260414  8:08:41 server id 1  end_log_pos 1641 CRC32 0x40e5509d 	Anonymous_GTID	last_committed=2	sequence_number=3	rbr_only=yes	original_committed_timestamp=1776164921299762	immediate_commit_timestamp=1776164921299762	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776164921299762 (2026-04-14 08:08:41.299762 Hora oficial do Brasil)
# immediate_commit_timestamp=1776164921299762 (2026-04-14 08:08:41.299762 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776164921299762*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 1641
#260414  8:08:41 server id 1  end_log_pos 1736 CRC32 0x98b63cce 	Query	thread_id=18	exec_time=0	error_code=0
SET TIMESTAMP=1776164921/*!*/;
BEGIN
/*!*/;
# at 1736
#260414  8:08:41 server id 1  end_log_pos 1828 CRC32 0x711c1694 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 1828
#260414  8:08:41 server id 1  end_log_pos 2031 CRC32 0x2cfb9623 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=846
###   @2=82
###   @3='Venda realizada - Coleta #1188'
###   @4=118.00
###   @5='2026:04:14'
###   @6=NULL
###   @7='2026:04:13'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086149
###   @13=1776086149
### SET
###   @1=846
###   @2=82
###   @3='Venda realizada - Coleta #1188'
###   @4=118.00
###   @5='2026:04:14'
###   @6='2026:04:14'
###   @7='2026:04:13'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086149
###   @13=1776175721
# at 2031
#260414  8:08:41 server id 1  end_log_pos 2116 CRC32 0x7b33d284 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 2116
#260414  8:08:41 server id 1  end_log_pos 2233 CRC32 0xced1fbb9 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=797
###   @2='2026:04:14'
###   @3=1
###   @4=118.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #846'
###   @8=846
###   @9=1776175721
###   @10=1776175721
# at 2233
#260414  8:08:41 server id 1  end_log_pos 2264 CRC32 0x7eb8eee2 	Xid = 163
COMMIT/*!*/;
# at 2264
#260414  8:09:28 server id 1  end_log_pos 2343 CRC32 0xe65f72d7 	Anonymous_GTID	last_committed=3	sequence_number=4	rbr_only=yes	original_committed_timestamp=1776164968562913	immediate_commit_timestamp=1776164968562913	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776164968562913 (2026-04-14 08:09:28.562913 Hora oficial do Brasil)
# immediate_commit_timestamp=1776164968562913 (2026-04-14 08:09:28.562913 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776164968562913*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 2343
#260414  8:09:28 server id 1  end_log_pos 2438 CRC32 0x18839df9 	Query	thread_id=21	exec_time=0	error_code=0
SET TIMESTAMP=1776164968/*!*/;
BEGIN
/*!*/;
# at 2438
#260414  8:09:28 server id 1  end_log_pos 2530 CRC32 0x40d00fe4 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 2530
#260414  8:09:28 server id 1  end_log_pos 2733 CRC32 0x7b2da5c4 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=848
###   @2=37
###   @3='Venda realizada - Coleta #1190'
###   @4=19.00
###   @5='2026:04:14'
###   @6=NULL
###   @7='2026:04:13'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086191
###   @13=1776086191
### SET
###   @1=848
###   @2=37
###   @3='Venda realizada - Coleta #1190'
###   @4=19.00
###   @5='2026:04:14'
###   @6='2026:04:14'
###   @7='2026:04:13'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086191
###   @13=1776175768
# at 2733
#260414  8:09:28 server id 1  end_log_pos 2818 CRC32 0xe7919b25 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 2818
#260414  8:09:28 server id 1  end_log_pos 2935 CRC32 0x0a0ac83e 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=798
###   @2='2026:04:14'
###   @3=1
###   @4=19.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #848'
###   @8=848
###   @9=1776175768
###   @10=1776175768
# at 2935
#260414  8:09:28 server id 1  end_log_pos 2966 CRC32 0xbbf1aa52 	Xid = 210
COMMIT/*!*/;
# at 2966
#260414  8:09:43 server id 1  end_log_pos 3045 CRC32 0xb7b9185f 	Anonymous_GTID	last_committed=4	sequence_number=5	rbr_only=yes	original_committed_timestamp=1776164983195076	immediate_commit_timestamp=1776164983195076	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776164983195076 (2026-04-14 08:09:43.195076 Hora oficial do Brasil)
# immediate_commit_timestamp=1776164983195076 (2026-04-14 08:09:43.195076 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776164983195076*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 3045
#260414  8:09:43 server id 1  end_log_pos 3140 CRC32 0xd56621f2 	Query	thread_id=24	exec_time=0	error_code=0
SET TIMESTAMP=1776164983/*!*/;
BEGIN
/*!*/;
# at 3140
#260414  8:09:43 server id 1  end_log_pos 3232 CRC32 0xdea8f29e 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 3232
#260414  8:09:43 server id 1  end_log_pos 3435 CRC32 0x50fb3ed4 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=849
###   @2=284
###   @3='Venda realizada - Coleta #1193'
###   @4=118.00
###   @5='2026:04:14'
###   @6=NULL
###   @7='2026:04:13'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086390
###   @13=1776086390
### SET
###   @1=849
###   @2=284
###   @3='Venda realizada - Coleta #1193'
###   @4=118.00
###   @5='2026:04:14'
###   @6='2026:04:14'
###   @7='2026:04:13'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776086390
###   @13=1776175783
# at 3435
#260414  8:09:43 server id 1  end_log_pos 3520 CRC32 0xb90d047e 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 3520
#260414  8:09:43 server id 1  end_log_pos 3637 CRC32 0xc419eb2a 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=799
###   @2='2026:04:14'
###   @3=1
###   @4=118.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #849'
###   @8=849
###   @9=1776175783
###   @10=1776175783
# at 3637
#260414  8:09:43 server id 1  end_log_pos 3668 CRC32 0xe5bc84ed 	Xid = 257
COMMIT/*!*/;
# at 3668
#260414  8:11:15 server id 1  end_log_pos 3747 CRC32 0xe5ed0d82 	Anonymous_GTID	last_committed=1	sequence_number=6	rbr_only=yes	original_committed_timestamp=1776165075606583	immediate_commit_timestamp=1776165075606583	transaction_length=385
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165075606583 (2026-04-14 08:11:15.606583 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165075606583 (2026-04-14 08:11:15.606583 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165075606583*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 3747
#260414  8:11:15 server id 1  end_log_pos 3833 CRC32 0xdff47e16 	Query	thread_id=34	exec_time=0	error_code=0
SET TIMESTAMP=1776165075/*!*/;
BEGIN
/*!*/;
# at 3833
#260414  8:11:15 server id 1  end_log_pos 3928 CRC32 0xce1bd1c7 	Table_map: `marigas`.`fechamentos_caixa` mapped to number 97
# has_generated_invisible_primary_key=0
# at 3928
#260414  8:11:15 server id 1  end_log_pos 4022 CRC32 0x6b44e35c 	Write_rows: table id 97 flags: STMT_END_F
### INSERT INTO `marigas`.`fechamentos_caixa`
### SET
###   @1=55
###   @2='2026:04:13'
###   @3=1200.00
###   @4=1700.91
###   @5=2249.50
###   @6=2523.88
###   @7=1146.50
###   @8=1377.38
###   @9='CAIXA'
###   @10=1776175875
###   @11=1776175875
# at 4022
#260414  8:11:15 server id 1  end_log_pos 4053 CRC32 0xe516a017 	Xid = 393
COMMIT/*!*/;
# at 4053
#260414  8:11:15 server id 1  end_log_pos 4132 CRC32 0xdec03064 	Anonymous_GTID	last_committed=1	sequence_number=7	rbr_only=yes	original_committed_timestamp=1776165075609010	immediate_commit_timestamp=1776165075609010	transaction_length=414
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165075609010 (2026-04-14 08:11:15.609010 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165075609010 (2026-04-14 08:11:15.609010 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165075609010*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 4132
#260414  8:11:15 server id 1  end_log_pos 4227 CRC32 0xce36594a 	Query	thread_id=34	exec_time=0	error_code=0
SET TIMESTAMP=1776165075/*!*/;
BEGIN
/*!*/;
# at 4227
#260414  8:11:15 server id 1  end_log_pos 4308 CRC32 0x25e268cc 	Table_map: `marigas`.`caixas_abertos` mapped to number 98
# has_generated_invisible_primary_key=0
# at 4308
#260414  8:11:15 server id 1  end_log_pos 4436 CRC32 0x0a0744a9 	Update_rows: table id 98 flags: STMT_END_F
### UPDATE `marigas`.`caixas_abertos`
### WHERE
###   @1=59
###   @2='2026:04:13'
###   @3='2026-04-13 10:26:27'
###   @4=1
###   @5=1200.00
###   @6=1872.47
###   @7=1
###   @8=1776086787
###   @9=1776086787
### SET
###   @1=59
###   @2='2026:04:13'
###   @3='2026-04-13 10:26:27'
###   @4=1
###   @5=1200.00
###   @6=1872.47
###   @7=2
###   @8=1776086787
###   @9=1776175875
# at 4436
#260414  8:11:15 server id 1  end_log_pos 4467 CRC32 0x55c2d895 	Xid = 396
COMMIT/*!*/;
# at 4467
#260414  8:11:37 server id 1  end_log_pos 4546 CRC32 0x1d9f1d78 	Anonymous_GTID	last_committed=1	sequence_number=8	rbr_only=yes	original_committed_timestamp=1776165097053316	immediate_commit_timestamp=1776165097053316	transaction_length=358
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165097053316 (2026-04-14 08:11:37.053316 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165097053316 (2026-04-14 08:11:37.053316 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165097053316*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 4546
#260414  8:11:37 server id 1  end_log_pos 4632 CRC32 0x6fdb337b 	Query	thread_id=36	exec_time=0	error_code=0
SET TIMESTAMP=1776165097/*!*/;
BEGIN
/*!*/;
# at 4632
#260414  8:11:37 server id 1  end_log_pos 4713 CRC32 0x6ac3f84c 	Table_map: `marigas`.`caixas_abertos` mapped to number 98
# has_generated_invisible_primary_key=0
# at 4713
#260414  8:11:37 server id 1  end_log_pos 4794 CRC32 0x5a78fafd 	Write_rows: table id 98 flags: STMT_END_F
### INSERT INTO `marigas`.`caixas_abertos`
### SET
###   @1=60
###   @2='2026:04:14'
###   @3='2026-04-14 11:11:37'
###   @4=1
###   @5=1146.50
###   @6=1377.38
###   @7=1
###   @8=1776175897
###   @9=1776175897
# at 4794
#260414  8:11:37 server id 1  end_log_pos 4825 CRC32 0xa3bc9dee 	Xid = 420
COMMIT/*!*/;
# at 4825
#260414  8:16:01 server id 1  end_log_pos 4904 CRC32 0x0b4f8108 	Anonymous_GTID	last_committed=1	sequence_number=9	rbr_only=yes	original_committed_timestamp=1776165361204061	immediate_commit_timestamp=1776165361204061	transaction_length=391
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165361204061 (2026-04-14 08:16:01.204061 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165361204061 (2026-04-14 08:16:01.204061 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165361204061*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 4904
#260414  8:16:01 server id 1  end_log_pos 4990 CRC32 0x27f90bdd 	Query	thread_id=43	exec_time=0	error_code=0
SET TIMESTAMP=1776165361/*!*/;
BEGIN
/*!*/;
# at 4990
#260414  8:16:01 server id 1  end_log_pos 5077 CRC32 0x2aa8d8f2 	Table_map: `marigas`.`vale_gas` mapped to number 101
# has_generated_invisible_primary_key=0
# at 5077
#260414  8:16:01 server id 1  end_log_pos 5185 CRC32 0x94d3d7c5 	Write_rows: table id 101 flags: STMT_END_F
### INSERT INTO `marigas`.`vale_gas`
### SET
###   @1=12
###   @2='VG000012'
###   @3=1238
###   @4='2026:04:14'
###   @5=2
###   @6=1
###   @7=115.00
###   @8=2
###   @9=1
###   @10=NULL
###   @11=NULL
###   @12=NULL
###   @13=1
###   @14=NULL
###   @15=1776176161
###   @16=1776176161
# at 5185
#260414  8:16:01 server id 1  end_log_pos 5216 CRC32 0x503852b4 	Xid = 549
COMMIT/*!*/;
# at 5216
#260414  8:17:01 server id 1  end_log_pos 5295 CRC32 0x135e9e5f 	Anonymous_GTID	last_committed=9	sequence_number=10	rbr_only=yes	original_committed_timestamp=1776165421950610	immediate_commit_timestamp=1776165421950610	transaction_length=1307
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165421950610 (2026-04-14 08:17:01.950610 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165421950610 (2026-04-14 08:17:01.950610 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165421950610*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 5295
#260414  8:17:01 server id 1  end_log_pos 5383 CRC32 0xc4d8714e 	Query	thread_id=52	exec_time=0	error_code=0
SET TIMESTAMP=1776165421/*!*/;
BEGIN
/*!*/;
# at 5383
#260414  8:17:01 server id 1  end_log_pos 5486 CRC32 0x418bcbae 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 5486
#260414  8:17:01 server id 1  end_log_pos 5663 CRC32 0x235127cf 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1194
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='Gustavo Moretto Itikawa'
###   @8='RUA JOSE CANDIDO'
###   @9='106'
###   @10='HERMANS MORAIS DE BARROS'
###   @11='MARINGÁ'
###   @12=697
###   @13=NULL
###   @14=1776176221
###   @15=1776176221
###   @16=2
###   @17=1
###   @18=20.00
###   @19=1
# at 5663
#260414  8:17:01 server id 1  end_log_pos 5743 CRC32 0x52b3e45f 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 5743
#260414  8:17:01 server id 1  end_log_pos 5825 CRC32 0xf8988469 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1207
###   @2=1194
###   @3=3
###   @4=1
###   @5=19.00
###   @6=20.00
###   @7=1776176221
###   @8=1776176221
# at 5825
#260414  8:17:01 server id 1  end_log_pos 5899 CRC32 0xf5b8a635 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 5899
#260414  8:17:01 server id 1  end_log_pos 5981 CRC32 0x9d40f662 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1603
###   @2=3
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176221
###   @7=1776176221
###   @8=1776176221
# at 5981
#260414  8:17:01 server id 1  end_log_pos 6072 CRC32 0x1ed57428 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 6072
#260414  8:17:01 server id 1  end_log_pos 6296 CRC32 0x9402fda3 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=48
###   @9='UNI'
###   @10=1768082861
###   @11=1776086191
###   @12=5
###   @13='7898116270607'
###   @14=1
### SET
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=47
###   @9='UNI'
###   @10=1768082861
###   @11=1776176221
###   @12=5
###   @13='7898116270607'
###   @14=1
# at 6296
#260414  8:17:01 server id 1  end_log_pos 6381 CRC32 0x51bb328c 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 6381
#260414  8:17:01 server id 1  end_log_pos 6492 CRC32 0x7d7decfc 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=800
###   @2='2026:04:14'
###   @3=1
###   @4=20.00
###   @5='pix'
###   @6='venda'
###   @7='Venda via PIX - Coleta #1194'
###   @8=1194
###   @9=1776176221
###   @10=1776176221
# at 6492
#260414  8:17:01 server id 1  end_log_pos 6523 CRC32 0x2929d538 	Xid = 646
COMMIT/*!*/;
# at 6523
#260414  8:17:41 server id 1  end_log_pos 6602 CRC32 0x84235c0e 	Anonymous_GTID	last_committed=10	sequence_number=11	rbr_only=yes	original_committed_timestamp=1776165461528852	immediate_commit_timestamp=1776165461528852	transaction_length=1259
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165461528852 (2026-04-14 08:17:41.528852 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165461528852 (2026-04-14 08:17:41.528852 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165461528852*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 6602
#260414  8:17:41 server id 1  end_log_pos 6690 CRC32 0x436a95f6 	Query	thread_id=61	exec_time=0	error_code=0
SET TIMESTAMP=1776165461/*!*/;
BEGIN
/*!*/;
# at 6690
#260414  8:17:41 server id 1  end_log_pos 6793 CRC32 0x46762377 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 6793
#260414  8:17:41 server id 1  end_log_pos 6946 CRC32 0xc83aa3a1 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1195
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='ANA VIRGINIA'
###   @8='RUA ANIBAL BORIN'
###   @9='88'
###   @10='JARDIM PARIS'
###   @11='MARINGÁ'
###   @12=33
###   @13=NULL
###   @14=1776176261
###   @15=1776176261
###   @16=2
###   @17=1
###   @18=125.00
###   @19=1
# at 6946
#260414  8:17:41 server id 1  end_log_pos 7026 CRC32 0x6b099315 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 7026
#260414  8:17:41 server id 1  end_log_pos 7108 CRC32 0xb30ecfbc 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1208
###   @2=1195
###   @3=2
###   @4=1
###   @5=118.00
###   @6=125.00
###   @7=1776176261
###   @8=1776176261
# at 7108
#260414  8:17:41 server id 1  end_log_pos 7182 CRC32 0xb761b85c 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 7182
#260414  8:17:41 server id 1  end_log_pos 7264 CRC32 0xbd0cdf6b 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1604
###   @2=2
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176261
###   @7=1776176261
###   @8=1776176261
# at 7264
#260414  8:17:41 server id 1  end_log_pos 7355 CRC32 0xe2ab126d 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 7355
#260414  8:17:41 server id 1  end_log_pos 7555 CRC32 0x7dbac280 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=11
###   @9='UNI'
###   @10=1768075554
###   @11=1776086491
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=10
###   @9='UNI'
###   @10=1768075554
###   @11=1776176261
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 7555
#260414  8:17:41 server id 1  end_log_pos 7640 CRC32 0x4cd2da62 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 7640
#260414  8:17:41 server id 1  end_log_pos 7751 CRC32 0x65d666d7 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=801
###   @2='2026:04:14'
###   @3=1
###   @4=125.00
###   @5='pix'
###   @6='venda'
###   @7='Venda via PIX - Coleta #1195'
###   @8=1195
###   @9=1776176261
###   @10=1776176261
# at 7751
#260414  8:17:41 server id 1  end_log_pos 7782 CRC32 0x49b1f472 	Xid = 804
COMMIT/*!*/;
# at 7782
#260414  8:18:19 server id 1  end_log_pos 7861 CRC32 0xe8199a91 	Anonymous_GTID	last_committed=11	sequence_number=12	rbr_only=yes	original_committed_timestamp=1776165499845375	immediate_commit_timestamp=1776165499845375	transaction_length=1297
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165499845375 (2026-04-14 08:18:19.845375 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165499845375 (2026-04-14 08:18:19.845375 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165499845375*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 7861
#260414  8:18:19 server id 1  end_log_pos 7949 CRC32 0xe2ae6b38 	Query	thread_id=69	exec_time=0	error_code=0
SET TIMESTAMP=1776165499/*!*/;
BEGIN
/*!*/;
# at 7949
#260414  8:18:19 server id 1  end_log_pos 8052 CRC32 0x72a6fe88 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 8052
#260414  8:18:19 server id 1  end_log_pos 8219 CRC32 0x2fdd2db9 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1196
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='CLEUSA LINDES'
###   @8='RUA CEREJEIRA'
###   @9='273 FUNDOS'
###   @10='PARQUE DAS PALMEIRAS'
###   @11='MARINGÁ'
###   @12=35
###   @13=NULL
###   @14=1776176299
###   @15=1776176299
###   @16=2
###   @17=1
###   @18=20.00
###   @19=1
# at 8219
#260414  8:18:19 server id 1  end_log_pos 8299 CRC32 0x8fd70d00 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 8299
#260414  8:18:19 server id 1  end_log_pos 8381 CRC32 0xaab0b255 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1209
###   @2=1196
###   @3=3
###   @4=1
###   @5=19.00
###   @6=20.00
###   @7=1776176299
###   @8=1776176299
# at 8381
#260414  8:18:19 server id 1  end_log_pos 8455 CRC32 0xb60b0477 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 8455
#260414  8:18:19 server id 1  end_log_pos 8537 CRC32 0xd43727ae 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1605
###   @2=3
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176299
###   @7=1776176299
###   @8=1776176299
# at 8537
#260414  8:18:19 server id 1  end_log_pos 8628 CRC32 0xf548dbc8 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 8628
#260414  8:18:19 server id 1  end_log_pos 8852 CRC32 0x9e62fd83 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=47
###   @9='UNI'
###   @10=1768082861
###   @11=1776176221
###   @12=5
###   @13='7898116270607'
###   @14=1
### SET
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=46
###   @9='UNI'
###   @10=1768082861
###   @11=1776176299
###   @12=5
###   @13='7898116270607'
###   @14=1
# at 8852
#260414  8:18:19 server id 1  end_log_pos 8937 CRC32 0xd27a106f 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 8937
#260414  8:18:19 server id 1  end_log_pos 9048 CRC32 0x0177a21f 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=802
###   @2='2026:04:14'
###   @3=1
###   @4=20.00
###   @5='pix'
###   @6='venda'
###   @7='Venda via PIX - Coleta #1196'
###   @8=1196
###   @9=1776176299
###   @10=1776176299
# at 9048
#260414  8:18:19 server id 1  end_log_pos 9079 CRC32 0xcc0ed69a 	Xid = 956
COMMIT/*!*/;
# at 9079
#260414  8:18:43 server id 1  end_log_pos 9158 CRC32 0x65ffbb76 	Anonymous_GTID	last_committed=12	sequence_number=13	rbr_only=yes	original_committed_timestamp=1776165523433504	immediate_commit_timestamp=1776165523433504	transaction_length=1300
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165523433504 (2026-04-14 08:18:43.433504 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165523433504 (2026-04-14 08:18:43.433504 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165523433504*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 9158
#260414  8:18:43 server id 1  end_log_pos 9246 CRC32 0x437d9d3c 	Query	thread_id=92	exec_time=0	error_code=0
SET TIMESTAMP=1776165523/*!*/;
BEGIN
/*!*/;
# at 9246
#260414  8:18:43 server id 1  end_log_pos 9349 CRC32 0x322df794 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 9349
#260414  8:18:43 server id 1  end_log_pos 9506 CRC32 0xe43262ad 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1197
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='Dona Zenilde'
###   @8='RUA ERNESTO VOLPATO'
###   @9='326'
###   @10='JARDIM PARIS'
###   @11='MARINGÁ'
###   @12=486
###   @13=NULL
###   @14=1776176323
###   @15=1776176323
###   @16=4
###   @17=1
###   @18=19.00
###   @19=1
# at 9506
#260414  8:18:43 server id 1  end_log_pos 9586 CRC32 0x85d8197f 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 9586
#260414  8:18:43 server id 1  end_log_pos 9668 CRC32 0x8fc99a79 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1210
###   @2=1197
###   @3=3
###   @4=1
###   @5=19.00
###   @6=19.00
###   @7=1776176323
###   @8=1776176323
# at 9668
#260414  8:18:43 server id 1  end_log_pos 9742 CRC32 0x35653a03 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 9742
#260414  8:18:43 server id 1  end_log_pos 9824 CRC32 0xe9ab9d3b 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1606
###   @2=3
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176323
###   @7=1776176323
###   @8=1776176323
# at 9824
#260414  8:18:43 server id 1  end_log_pos 9915 CRC32 0x5d025b8a 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 9915
#260414  8:18:43 server id 1  end_log_pos 10139 CRC32 0xd3cf929f 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=46
###   @9='UNI'
###   @10=1768082861
###   @11=1776176299
###   @12=5
###   @13='7898116270607'
###   @14=1
### SET
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=45
###   @9='UNI'
###   @10=1768082861
###   @11=1776176323
###   @12=5
###   @13='7898116270607'
###   @14=1
# at 10139
#260414  8:18:43 server id 1  end_log_pos 10231 CRC32 0x80ef0bb5 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 10231
#260414  8:18:43 server id 1  end_log_pos 10348 CRC32 0x3fb592b6 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=850
###   @2=486
###   @3='Venda realizada - Coleta #1197'
###   @4=19.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176323
###   @13=1776176323
# at 10348
#260414  8:18:43 server id 1  end_log_pos 10379 CRC32 0xd1e9d735 	Xid = 1198
COMMIT/*!*/;
# at 10379
#260414  8:20:09 server id 1  end_log_pos 10458 CRC32 0xf862259c 	Anonymous_GTID	last_committed=13	sequence_number=14	rbr_only=yes	original_committed_timestamp=1776165609430737	immediate_commit_timestamp=1776165609430737	transaction_length=548
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165609430737 (2026-04-14 08:20:09.430737 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165609430737 (2026-04-14 08:20:09.430737 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165609430737*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 10458
#260414  8:20:09 server id 1  end_log_pos 10555 CRC32 0xc4474154 	Query	thread_id=100	exec_time=0	error_code=0
SET TIMESTAMP=1776165609/*!*/;
BEGIN
/*!*/;
# at 10555
#260414  8:20:09 server id 1  end_log_pos 10647 CRC32 0xa3c8e36a 	Table_map: `marigas`.`clientes` mapped to number 92
# has_generated_invisible_primary_key=0
# at 10647
#260414  8:20:09 server id 1  end_log_pos 10896 CRC32 0xbd3321f3 	Update_rows: table id 92 flags: STMT_END_F
### UPDATE `marigas`.`clientes`
### WHERE
###   @1=242
###   @2='(44) 32536545'
###   @3='111.111.111-11'
###   @4='ANINHA ACESSÓRIOS'
###   @5=''
###   @6=''
###   @7=''
###   @8='MARINGÁ'
###   @9=NULL
###   @10=NULL
###   @11=NULL
###   @12=1768536389
###   @13=1768536389
### SET
###   @1=242
###   @2='(44) 3253-6545'
###   @3='111.111.111-11'
###   @4='ANINHA ACESSÓRIOS'
###   @5='Avenida das Palmeiras'
###   @6='473'
###   @7='Parque Palmeiras'
###   @8='MARINGÁ'
###   @9=NULL
###   @10=NULL
###   @11=NULL
###   @12=1768536389
###   @13=1776176409
# at 10896
#260414  8:20:09 server id 1  end_log_pos 10927 CRC32 0x7f849c84 	Xid = 1343
COMMIT/*!*/;
# at 10927
#260414  8:20:29 server id 1  end_log_pos 11006 CRC32 0x823c89aa 	Anonymous_GTID	last_committed=14	sequence_number=15	rbr_only=yes	original_committed_timestamp=1776165629179490	immediate_commit_timestamp=1776165629179490	transaction_length=1290
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165629179490 (2026-04-14 08:20:29.179490 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165629179490 (2026-04-14 08:20:29.179490 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165629179490*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 11006
#260414  8:20:29 server id 1  end_log_pos 11094 CRC32 0x077d6c77 	Query	thread_id=107	exec_time=0	error_code=0
SET TIMESTAMP=1776165629/*!*/;
BEGIN
/*!*/;
# at 11094
#260414  8:20:29 server id 1  end_log_pos 11197 CRC32 0xcd967a55 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 11197
#260414  8:20:29 server id 1  end_log_pos 11366 CRC32 0x06856525 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1198
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='ANINHA ACESSÓRIOS'
###   @8='Avenida das Palmeiras'
###   @9='473'
###   @10='Parque Palmeiras'
###   @11='MARINGÁ'
###   @12=242
###   @13=NULL
###   @14=1776176429
###   @15=1776176429
###   @16=1
###   @17=1
###   @18=22.00
###   @19=1
# at 11366
#260414  8:20:29 server id 1  end_log_pos 11446 CRC32 0xd6b4f141 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 11446
#260414  8:20:29 server id 1  end_log_pos 11528 CRC32 0xe5851394 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1211
###   @2=1198
###   @3=3
###   @4=1
###   @5=19.00
###   @6=22.00
###   @7=1776176429
###   @8=1776176429
# at 11528
#260414  8:20:29 server id 1  end_log_pos 11602 CRC32 0xfd8cc126 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 11602
#260414  8:20:29 server id 1  end_log_pos 11684 CRC32 0xa34a1cfa 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1607
###   @2=3
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176429
###   @7=1776176429
###   @8=1776176429
# at 11684
#260414  8:20:29 server id 1  end_log_pos 11775 CRC32 0x2dda60da 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 11775
#260414  8:20:29 server id 1  end_log_pos 11999 CRC32 0x210def3d 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=45
###   @9='UNI'
###   @10=1768082861
###   @11=1776176323
###   @12=5
###   @13='7898116270607'
###   @14=1
### SET
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=44
###   @9='UNI'
###   @10=1768082861
###   @11=1776176429
###   @12=5
###   @13='7898116270607'
###   @14=1
# at 11999
#260414  8:20:29 server id 1  end_log_pos 12075 CRC32 0x28b084f8 	Table_map: `marigas`.`caixa` mapped to number 99
# has_generated_invisible_primary_key=0
# at 12075
#260414  8:20:29 server id 1  end_log_pos 12186 CRC32 0x7849efdf 	Write_rows: table id 99 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa`
### SET
###   @1=444
###   @2='2026:04:14'
###   @3=1
###   @4=22.00
###   @5='venda'
###   @6='Venda em dinheiro - Coleta #1198'
###   @7=1198
###   @8=1776176429
###   @9=1776176429
# at 12186
#260414  8:20:29 server id 1  end_log_pos 12217 CRC32 0x8e1d5b2b 	Xid = 1410
COMMIT/*!*/;
# at 12217
#260414  8:20:52 server id 1  end_log_pos 12296 CRC32 0x6c7880b8 	Anonymous_GTID	last_committed=15	sequence_number=16	rbr_only=yes	original_committed_timestamp=1776165652822066	immediate_commit_timestamp=1776165652822066	transaction_length=1270
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165652822066 (2026-04-14 08:20:52.822066 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165652822066 (2026-04-14 08:20:52.822066 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165652822066*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 12296
#260414  8:20:52 server id 1  end_log_pos 12384 CRC32 0x15273c19 	Query	thread_id=113	exec_time=0	error_code=0
SET TIMESTAMP=1776165652/*!*/;
BEGIN
/*!*/;
# at 12384
#260414  8:20:52 server id 1  end_log_pos 12487 CRC32 0x2ba5caf4 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 12487
#260414  8:20:52 server id 1  end_log_pos 12638 CRC32 0x3d5add99 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1199
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='FEIJÃO & BRASA'
###   @8='AV MANDACARU'
###   @9='30'
###   @10='LARANJEIRAS'
###   @11='MARINGÁ'
###   @12=1578
###   @13=NULL
###   @14=1776176452
###   @15=1776176452
###   @16=5
###   @17=1
###   @18=118.00
###   @19=1
# at 12638
#260414  8:20:52 server id 1  end_log_pos 12718 CRC32 0xf4fdcfc9 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 12718
#260414  8:20:52 server id 1  end_log_pos 12800 CRC32 0x64ca89f9 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1212
###   @2=1199
###   @3=2
###   @4=1
###   @5=118.00
###   @6=118.00
###   @7=1776176452
###   @8=1776176452
# at 12800
#260414  8:20:52 server id 1  end_log_pos 12874 CRC32 0x557feca9 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 12874
#260414  8:20:52 server id 1  end_log_pos 12956 CRC32 0xa2fd7815 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1608
###   @2=2
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176452
###   @7=1776176452
###   @8=1776176452
# at 12956
#260414  8:20:52 server id 1  end_log_pos 13047 CRC32 0xc43f4f19 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 13047
#260414  8:20:52 server id 1  end_log_pos 13247 CRC32 0xaefd6b26 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=10
###   @9='UNI'
###   @10=1768075554
###   @11=1776176261
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=9
###   @9='UNI'
###   @10=1768075554
###   @11=1776176452
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 13247
#260414  8:20:52 server id 1  end_log_pos 13339 CRC32 0xff48b6e3 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 13339
#260414  8:20:52 server id 1  end_log_pos 13456 CRC32 0x34c29eb4 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=851
###   @2=1578
###   @3='Venda realizada - Coleta #1199'
###   @4=118.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=5
###   @10='1'
###   @11=NULL
###   @12=1776176452
###   @13=1776176452
# at 13456
#260414  8:20:52 server id 1  end_log_pos 13487 CRC32 0xbdb07908 	Xid = 1550
COMMIT/*!*/;
# at 13487
#260414  8:21:11 server id 1  end_log_pos 13566 CRC32 0x07d2e858 	Anonymous_GTID	last_committed=16	sequence_number=17	rbr_only=yes	original_committed_timestamp=1776165671033749	immediate_commit_timestamp=1776165671033749	transaction_length=1282
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165671033749 (2026-04-14 08:21:11.033749 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165671033749 (2026-04-14 08:21:11.033749 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165671033749*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 13566
#260414  8:21:11 server id 1  end_log_pos 13654 CRC32 0xc2701d8c 	Query	thread_id=121	exec_time=0	error_code=0
SET TIMESTAMP=1776165671/*!*/;
BEGIN
/*!*/;
# at 13654
#260414  8:21:11 server id 1  end_log_pos 13757 CRC32 0x82b5dcca 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 13757
#260414  8:21:11 server id 1  end_log_pos 13920 CRC32 0x46933e56 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1200
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='Cleide Araujo'
###   @8='av DAS PALMEIRAS'
###   @9='682'
###   @10='PARQUE DAS PALMEIRAS'
###   @11='MARINGÁ'
###   @12=376
###   @13=NULL
###   @14=1776176471
###   @15=1776176471
###   @16=4
###   @17=1
###   @18=118.00
###   @19=1
# at 13920
#260414  8:21:11 server id 1  end_log_pos 14000 CRC32 0x92126803 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 14000
#260414  8:21:11 server id 1  end_log_pos 14082 CRC32 0xc11cb8fa 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1213
###   @2=1200
###   @3=2
###   @4=1
###   @5=118.00
###   @6=118.00
###   @7=1776176471
###   @8=1776176471
# at 14082
#260414  8:21:11 server id 1  end_log_pos 14156 CRC32 0xe7c6ac1f 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 14156
#260414  8:21:11 server id 1  end_log_pos 14238 CRC32 0x86edc375 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1609
###   @2=2
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176471
###   @7=1776176471
###   @8=1776176471
# at 14238
#260414  8:21:11 server id 1  end_log_pos 14329 CRC32 0xa42954a6 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 14329
#260414  8:21:11 server id 1  end_log_pos 14529 CRC32 0xa9cd0853 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=9
###   @9='UNI'
###   @10=1768075554
###   @11=1776176452
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=8
###   @9='UNI'
###   @10=1768075554
###   @11=1776176471
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 14529
#260414  8:21:11 server id 1  end_log_pos 14621 CRC32 0x7c7f38d5 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 14621
#260414  8:21:11 server id 1  end_log_pos 14738 CRC32 0x964bd729 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=852
###   @2=376
###   @3='Venda realizada - Coleta #1200'
###   @4=118.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176471
###   @13=1776176471
# at 14738
#260414  8:21:11 server id 1  end_log_pos 14769 CRC32 0x7f145c9f 	Xid = 1702
COMMIT/*!*/;
# at 14769
#260414  8:21:30 server id 1  end_log_pos 14848 CRC32 0x5f1648af 	Anonymous_GTID	last_committed=17	sequence_number=18	rbr_only=yes	original_committed_timestamp=1776165690845362	immediate_commit_timestamp=1776165690845362	transaction_length=1318
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776165690845362 (2026-04-14 08:21:30.845362 Hora oficial do Brasil)
# immediate_commit_timestamp=1776165690845362 (2026-04-14 08:21:30.845362 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776165690845362*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 14848
#260414  8:21:30 server id 1  end_log_pos 14936 CRC32 0x1477a3f7 	Query	thread_id=128	exec_time=0	error_code=0
SET TIMESTAMP=1776165690/*!*/;
BEGIN
/*!*/;
# at 14936
#260414  8:21:30 server id 1  end_log_pos 15039 CRC32 0x047178e5 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 15039
#260414  8:21:30 server id 1  end_log_pos 15214 CRC32 0x752cc530 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1201
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='JOAO - CABELEREIRO'
###   @8='RUA AGENOR CAMARGO'
###   @9='1165'
###   @10='HERMANS MORAIS DE BARROS'
###   @11='MARINGÁ'
###   @12=16
###   @13=NULL
###   @14=1776176490
###   @15=1776176490
###   @16=5
###   @17=1
###   @18=19.00
###   @19=1
# at 15214
#260414  8:21:30 server id 1  end_log_pos 15294 CRC32 0x0b51ea43 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 15294
#260414  8:21:30 server id 1  end_log_pos 15376 CRC32 0x01451ba9 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1214
###   @2=1201
###   @3=3
###   @4=1
###   @5=19.00
###   @6=19.00
###   @7=1776176490
###   @8=1776176490
# at 15376
#260414  8:21:30 server id 1  end_log_pos 15450 CRC32 0xf8ea48ed 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 15450
#260414  8:21:30 server id 1  end_log_pos 15532 CRC32 0x24ed96ad 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1610
###   @2=3
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176490
###   @7=1776176490
###   @8=1776176490
# at 15532
#260414  8:21:30 server id 1  end_log_pos 15623 CRC32 0x6cf14e29 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 15623
#260414  8:21:30 server id 1  end_log_pos 15847 CRC32 0x45aecd11 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=44
###   @9='UNI'
###   @10=1768082861
###   @11=1776176429
###   @12=5
###   @13='7898116270607'
###   @14=1
### SET
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=43
###   @9='UNI'
###   @10=1768082861
###   @11=1776176490
###   @12=5
###   @13='7898116270607'
###   @14=1
# at 15847
#260414  8:21:30 server id 1  end_log_pos 15939 CRC32 0x55ddebe9 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 15939
#260414  8:21:30 server id 1  end_log_pos 16056 CRC32 0x6364d88b 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=853
###   @2=16
###   @3='Venda realizada - Coleta #1201'
###   @4=19.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=5
###   @10='1'
###   @11=NULL
###   @12=1776176490
###   @13=1776176490
# at 16056
#260414  8:21:30 server id 1  end_log_pos 16087 CRC32 0x793e3ef4 	Xid = 1848
COMMIT/*!*/;
# at 16087
#260415  8:24:11 server id 1  end_log_pos 16166 CRC32 0xbcc05015 	Anonymous_GTID	last_committed=18	sequence_number=19	rbr_only=yes	original_committed_timestamp=1776252251453770	immediate_commit_timestamp=1776252251453770	transaction_length=551
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776252251453770 (2026-04-15 08:24:11.453770 Hora oficial do Brasil)
# immediate_commit_timestamp=1776252251453770 (2026-04-15 08:24:11.453770 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776252251453770*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 16166
#260415  8:24:11 server id 1  end_log_pos 16263 CRC32 0xd0e693b7 	Query	thread_id=137	exec_time=0	error_code=0
SET TIMESTAMP=1776252251/*!*/;
BEGIN
/*!*/;
# at 16263
#260415  8:24:11 server id 1  end_log_pos 16355 CRC32 0x47502d10 	Table_map: `marigas`.`clientes` mapped to number 92
# has_generated_invisible_primary_key=0
# at 16355
#260415  8:24:11 server id 1  end_log_pos 16607 CRC32 0xe147201f 	Update_rows: table id 92 flags: STMT_END_F
### UPDATE `marigas`.`clientes`
### WHERE
###   @1=737
###   @2='(44) 99761-1157'
###   @3='111.111.111-11'
###   @4='Isabel Marques'
###   @5=''
###   @6=''
###   @7=''
###   @8='MARINGÁ'
###   @9=NULL
###   @10=NULL
###   @11=NULL
###   @12=1768536390
###   @13=1768536390
### SET
###   @1=737
###   @2='(44) 99761-1157'
###   @3='111.111.111-11'
###   @4='Isabel Marques'
###   @5='Rua José Ferreira de Oliveira'
###   @6='208'
###   @7='JARDIM ORIENTAL'
###   @8='MARINGÁ'
###   @9=NULL
###   @10=NULL
###   @11=NULL
###   @12=1768536390
###   @13=1776263051
# at 16607
#260415  8:24:11 server id 1  end_log_pos 16638 CRC32 0x2bab4311 	Xid = 1999
COMMIT/*!*/;
# at 16638
#260415  8:25:40 server id 1  end_log_pos 16717 CRC32 0x5e62c34d 	Anonymous_GTID	last_committed=19	sequence_number=20	rbr_only=yes	original_committed_timestamp=1776252340370183	immediate_commit_timestamp=1776252340370183	transaction_length=1292
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776252340370183 (2026-04-15 08:25:40.370183 Hora oficial do Brasil)
# immediate_commit_timestamp=1776252340370183 (2026-04-15 08:25:40.370183 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776252340370183*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 16717
#260415  8:25:40 server id 1  end_log_pos 16805 CRC32 0x89924d68 	Query	thread_id=154	exec_time=0	error_code=0
SET TIMESTAMP=1776252340/*!*/;
BEGIN
/*!*/;
# at 16805
#260415  8:25:40 server id 1  end_log_pos 16908 CRC32 0x90f72de7 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 16908
#260415  8:25:40 server id 1  end_log_pos 17081 CRC32 0x5364ce43 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1202
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:15'
###   @6=NULL
###   @7='Isabel Marques'
###   @8='Rua José Ferreira de Oliveira'
###   @9='208'
###   @10='JARDIM ORIENTAL'
###   @11='MARINGÁ'
###   @12=737
###   @13=NULL
###   @14=1776263140
###   @15=1776263140
###   @16=4
###   @17=1
###   @18=118.00
###   @19=1
# at 17081
#260415  8:25:40 server id 1  end_log_pos 17161 CRC32 0x49abfdb8 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 17161
#260415  8:25:40 server id 1  end_log_pos 17243 CRC32 0x80cf6640 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1215
###   @2=1202
###   @3=2
###   @4=1
###   @5=118.00
###   @6=118.00
###   @7=1776263140
###   @8=1776263140
# at 17243
#260415  8:25:40 server id 1  end_log_pos 17317 CRC32 0xb6222b63 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 17317
#260415  8:25:40 server id 1  end_log_pos 17399 CRC32 0x487599d1 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1611
###   @2=2
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776263140
###   @7=1776263140
###   @8=1776263140
# at 17399
#260415  8:25:40 server id 1  end_log_pos 17490 CRC32 0xa713d3e8 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 17490
#260415  8:25:40 server id 1  end_log_pos 17690 CRC32 0xc4711314 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=8
###   @9='UNI'
###   @10=1768075554
###   @11=1776176471
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=7
###   @9='UNI'
###   @10=1768075554
###   @11=1776263140
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 17690
#260415  8:25:40 server id 1  end_log_pos 17782 CRC32 0x5f779830 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 17782
#260415  8:25:40 server id 1  end_log_pos 17899 CRC32 0xb7c8bd17 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=854
###   @2=737
###   @3='Venda realizada - Coleta #1202'
###   @4=118.00
###   @5='2026:04:16'
###   @6=NULL
###   @7='2026:04:15'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776263140
###   @13=1776263140
# at 17899
#260415  8:25:40 server id 1  end_log_pos 17930 CRC32 0x61f8ad05 	Xid = 2135
COMMIT/*!*/;
# at 17930
#260415  8:27:03 server id 1  end_log_pos 18009 CRC32 0x6d8cf4a1 	Anonymous_GTID	last_committed=20	sequence_number=21	rbr_only=yes	original_committed_timestamp=1776252423394082	immediate_commit_timestamp=1776252423394082	transaction_length=397
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776252423394082 (2026-04-15 08:27:03.394082 Hora oficial do Brasil)
# immediate_commit_timestamp=1776252423394082 (2026-04-15 08:27:03.394082 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776252423394082*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 18009
#260415  8:27:03 server id 1  end_log_pos 18087 CRC32 0x3da2b105 	Query	thread_id=161	exec_time=0	error_code=0
SET TIMESTAMP=1776252423/*!*/;
BEGIN
/*!*/;
# at 18087
#260415  8:27:03 server id 1  end_log_pos 18179 CRC32 0xc064d195 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 18179
#260415  8:27:03 server id 1  end_log_pos 18296 CRC32 0x7ed2ea46 	Delete_rows: table id 91 flags: STMT_END_F
### DELETE FROM `marigas`.`contas_a_receber`
### WHERE
###   @1=854
###   @2=737
###   @3='Venda realizada - Coleta #1202'
###   @4=118.00
###   @5='2026:04:16'
###   @6=NULL
###   @7='2026:04:15'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776263140
###   @13=1776263140
# at 18296
#260415  8:27:03 server id 1  end_log_pos 18327 CRC32 0xbf1f54f1 	Xid = 2289
COMMIT/*!*/;
# at 18327
#260415  8:27:13 server id 1  end_log_pos 18406 CRC32 0xc9927e5d 	Anonymous_GTID	last_committed=20	sequence_number=22	rbr_only=yes	original_committed_timestamp=1776252433161877	immediate_commit_timestamp=1776252433161877	transaction_length=350
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776252433161877 (2026-04-15 08:27:13.161877 Hora oficial do Brasil)
# immediate_commit_timestamp=1776252433161877 (2026-04-15 08:27:13.161877 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776252433161877*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 18406
#260415  8:27:13 server id 1  end_log_pos 18484 CRC32 0x8a2fbbfa 	Query	thread_id=164	exec_time=0	error_code=0
SET TIMESTAMP=1776252433/*!*/;
BEGIN
/*!*/;
# at 18484
#260415  8:27:13 server id 1  end_log_pos 18564 CRC32 0xddf70ace 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 18564
#260415  8:27:13 server id 1  end_log_pos 18646 CRC32 0x99107b9f 	Delete_rows: table id 102 flags: STMT_END_F
### DELETE FROM `marigas`.`movimentacao_itens`
### WHERE
###   @1=1215
###   @2=1202
###   @3=2
###   @4=1
###   @5=118.00
###   @6=118.00
###   @7=1776263140
###   @8=1776263140
# at 18646
#260415  8:27:13 server id 1  end_log_pos 18677 CRC32 0xf6b0fd09 	Xid = 2379
COMMIT/*!*/;
# at 18677
#260415  8:27:13 server id 1  end_log_pos 18756 CRC32 0x09f77f93 	Anonymous_GTID	last_committed=22	sequence_number=23	rbr_only=yes	original_committed_timestamp=1776252433166491	immediate_commit_timestamp=1776252433166491	transaction_length=466
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776252433166491 (2026-04-15 08:27:13.166491 Hora oficial do Brasil)
# immediate_commit_timestamp=1776252433166491 (2026-04-15 08:27:13.166491 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776252433166491*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 18756
#260415  8:27:13 server id 1  end_log_pos 18836 CRC32 0xdcd4bcde 	Query	thread_id=164	exec_time=0	error_code=0
SET TIMESTAMP=1776252433/*!*/;
BEGIN
/*!*/;
# at 18836
#260415  8:27:13 server id 1  end_log_pos 18939 CRC32 0x4415de34 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 18939
#260415  8:27:13 server id 1  end_log_pos 19112 CRC32 0xd81dd804 	Delete_rows: table id 100 flags: STMT_END_F
### DELETE FROM `marigas`.`movimentacao`
### WHERE
###   @1=1202
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:15'
###   @6=NULL
###   @7='Isabel Marques'
###   @8='Rua José Ferreira de Oliveira'
###   @9='208'
###   @10='JARDIM ORIENTAL'
###   @11='MARINGÁ'
###   @12=737
###   @13=NULL
###   @14=1776263140
###   @15=1776263140
###   @16=4
###   @17=1
###   @18=118.00
###   @19=1
# at 19112
#260415  8:27:13 server id 1  end_log_pos 19143 CRC32 0x312fe5b8 	Xid = 2385
COMMIT/*!*/;
# at 19143
#260414  8:28:16 server id 1  end_log_pos 19222 CRC32 0x65ed31d4 	Anonymous_GTID	last_committed=23	sequence_number=24	rbr_only=yes	original_committed_timestamp=1776166096466199	immediate_commit_timestamp=1776166096466199	transaction_length=1292
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776166096466199 (2026-04-14 08:28:16.466199 Hora oficial do Brasil)
# immediate_commit_timestamp=1776166096466199 (2026-04-14 08:28:16.466199 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776166096466199*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 19222
#260414  8:28:16 server id 1  end_log_pos 19310 CRC32 0x042f16ed 	Query	thread_id=181	exec_time=0	error_code=0
SET TIMESTAMP=1776166096/*!*/;
BEGIN
/*!*/;
# at 19310
#260414  8:28:16 server id 1  end_log_pos 19413 CRC32 0xf3dc59b4 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 19413
#260414  8:28:16 server id 1  end_log_pos 19586 CRC32 0x9865fc28 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1203
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='Isabel Marques'
###   @8='Rua José Ferreira de Oliveira'
###   @9='208'
###   @10='JARDIM ORIENTAL'
###   @11='MARINGÁ'
###   @12=737
###   @13=NULL
###   @14=1776176896
###   @15=1776176896
###   @16=4
###   @17=1
###   @18=118.00
###   @19=1
# at 19586
#260414  8:28:16 server id 1  end_log_pos 19666 CRC32 0x810901a7 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 19666
#260414  8:28:16 server id 1  end_log_pos 19748 CRC32 0x1a5a1bb6 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1216
###   @2=1203
###   @3=2
###   @4=1
###   @5=118.00
###   @6=118.00
###   @7=1776176896
###   @8=1776176896
# at 19748
#260414  8:28:16 server id 1  end_log_pos 19822 CRC32 0x816cd84a 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 19822
#260414  8:28:16 server id 1  end_log_pos 19904 CRC32 0x2794adfc 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1612
###   @2=2
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776176896
###   @7=1776176896
###   @8=1776176896
# at 19904
#260414  8:28:16 server id 1  end_log_pos 19995 CRC32 0xac1d94e6 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 19995
#260414  8:28:16 server id 1  end_log_pos 20195 CRC32 0xbe585a87 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=7
###   @9='UNI'
###   @10=1768075554
###   @11=1776263140
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=6
###   @9='UNI'
###   @10=1768075554
###   @11=1776176896
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 20195
#260414  8:28:16 server id 1  end_log_pos 20287 CRC32 0xb8c4bb70 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 20287
#260414  8:28:16 server id 1  end_log_pos 20404 CRC32 0x264fb565 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=855
###   @2=737
###   @3='Venda realizada - Coleta #1203'
###   @4=118.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176896
###   @13=1776176896
# at 20404
#260414  8:28:16 server id 1  end_log_pos 20435 CRC32 0x68651037 	Xid = 2569
COMMIT/*!*/;
# at 20435
#260414  8:45:41 server id 1  end_log_pos 20514 CRC32 0xf61f0019 	Anonymous_GTID	last_committed=24	sequence_number=25	rbr_only=yes	original_committed_timestamp=1776167141192937	immediate_commit_timestamp=1776167141192937	transaction_length=452
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167141192937 (2026-04-14 08:45:41.192937 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167141192937 (2026-04-14 08:45:41.192937 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167141192937*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 20514
#260414  8:45:41 server id 1  end_log_pos 20602 CRC32 0xef034953 	Query	thread_id=224	exec_time=0	error_code=0
SET TIMESTAMP=1776167141/*!*/;
BEGIN
/*!*/;
# at 20602
#260414  8:45:41 server id 1  end_log_pos 20694 CRC32 0x0f9df4dc 	Table_map: `marigas`.`clientes` mapped to number 92
# has_generated_invisible_primary_key=0
# at 20694
#260414  8:45:41 server id 1  end_log_pos 20856 CRC32 0x3c2da560 	Write_rows: table id 92 flags: STMT_END_F
### INSERT INTO `marigas`.`clientes`
### SET
###   @1=1687
###   @2='4430301838'
###   @3='111.111.111-11'
###   @4='ADERVAL PAI DO MARCELO'
###   @5='RUA AGENOR CAMARGO'
###   @6='COPACABANA 2'
###   @7='COPACABANA'
###   @8='Maringá'
###   @9=NULL
###   @10=NULL
###   @11=NULL
###   @12=1776177941
###   @13=1776177941
# at 20856
#260414  8:45:41 server id 1  end_log_pos 20887 CRC32 0x5c8f56a6 	Xid = 2927
COMMIT/*!*/;
# at 20887
#260414  8:46:05 server id 1  end_log_pos 20966 CRC32 0xd8a4f6f4 	Anonymous_GTID	last_committed=25	sequence_number=26	rbr_only=yes	original_committed_timestamp=1776167165348883	immediate_commit_timestamp=1776167165348883	transaction_length=1292
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167165348883 (2026-04-14 08:46:05.348883 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167165348883 (2026-04-14 08:46:05.348883 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167165348883*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 20966
#260414  8:46:05 server id 1  end_log_pos 21054 CRC32 0xa78bf357 	Query	thread_id=230	exec_time=0	error_code=0
SET TIMESTAMP=1776167165/*!*/;
BEGIN
/*!*/;
# at 21054
#260414  8:46:05 server id 1  end_log_pos 21157 CRC32 0x226731c0 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 21157
#260414  8:46:05 server id 1  end_log_pos 21330 CRC32 0xb5c77aa1 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1204
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='ADERVAL PAI DO MARCELO'
###   @8='RUA AGENOR CAMARGO'
###   @9='COPACABANA 2'
###   @10='COPACABANA'
###   @11='Maringá'
###   @12=1687
###   @13=NULL
###   @14=1776177965
###   @15=1776177965
###   @16=4
###   @17=1
###   @18=118.00
###   @19=1
# at 21330
#260414  8:46:05 server id 1  end_log_pos 21410 CRC32 0x7d7b0f9a 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 21410
#260414  8:46:05 server id 1  end_log_pos 21492 CRC32 0xf251f29a 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1217
###   @2=1204
###   @3=2
###   @4=1
###   @5=118.00
###   @6=118.00
###   @7=1776177965
###   @8=1776177965
# at 21492
#260414  8:46:05 server id 1  end_log_pos 21566 CRC32 0xf5f0f335 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 21566
#260414  8:46:05 server id 1  end_log_pos 21648 CRC32 0x26a064ed 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1613
###   @2=2
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776177965
###   @7=1776177965
###   @8=1776177965
# at 21648
#260414  8:46:05 server id 1  end_log_pos 21739 CRC32 0xc24246ab 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 21739
#260414  8:46:05 server id 1  end_log_pos 21939 CRC32 0x8663cad1 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=6
###   @9='UNI'
###   @10=1768075554
###   @11=1776176896
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=5
###   @9='UNI'
###   @10=1768075554
###   @11=1776177965
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 21939
#260414  8:46:05 server id 1  end_log_pos 22031 CRC32 0x7eceb548 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 22031
#260414  8:46:05 server id 1  end_log_pos 22148 CRC32 0xdc355037 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=856
###   @2=1687
###   @3='Venda realizada - Coleta #1204'
###   @4=118.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776177965
###   @13=1776177965
# at 22148
#260414  8:46:05 server id 1  end_log_pos 22179 CRC32 0xfb59a65a 	Xid = 2988
COMMIT/*!*/;
# at 22179
#260414  8:46:24 server id 1  end_log_pos 22258 CRC32 0xb0f1950e 	Anonymous_GTID	last_committed=26	sequence_number=27	rbr_only=yes	original_committed_timestamp=1776167184022111	immediate_commit_timestamp=1776167184022111	transaction_length=1259
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167184022111 (2026-04-14 08:46:24.022111 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167184022111 (2026-04-14 08:46:24.022111 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167184022111*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 22258
#260414  8:46:24 server id 1  end_log_pos 22346 CRC32 0x6a6cd945 	Query	thread_id=240	exec_time=0	error_code=0
SET TIMESTAMP=1776167184/*!*/;
BEGIN
/*!*/;
# at 22346
#260414  8:46:24 server id 1  end_log_pos 22449 CRC32 0xd3ca6735 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 22449
#260414  8:46:24 server id 1  end_log_pos 22611 CRC32 0x515d934e 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1205
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='CLIENTES NÃO CADASTRADOS'
###   @8='S/N'
###   @9='S/N'
###   @10='PARQUE DAS PALMEIRAS'
###   @11='MARINGÁ'
###   @12=1521
###   @13=NULL
###   @14=1776177984
###   @15=1776177984
###   @16=1
###   @17=1
###   @18=120.00
###   @19=1
# at 22611
#260414  8:46:24 server id 1  end_log_pos 22691 CRC32 0x00aa1cbc 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 22691
#260414  8:46:24 server id 1  end_log_pos 22773 CRC32 0xf48b824c 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1218
###   @2=1205
###   @3=2
###   @4=1
###   @5=118.00
###   @6=120.00
###   @7=1776177984
###   @8=1776177984
# at 22773
#260414  8:46:24 server id 1  end_log_pos 22847 CRC32 0x56c0448d 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 22847
#260414  8:46:24 server id 1  end_log_pos 22929 CRC32 0x8a4b5e65 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1614
###   @2=2
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776177984
###   @7=1776177984
###   @8=1776177984
# at 22929
#260414  8:46:24 server id 1  end_log_pos 23020 CRC32 0x37d26711 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 23020
#260414  8:46:24 server id 1  end_log_pos 23220 CRC32 0xef6c2ed4 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=5
###   @9='UNI'
###   @10=1768075554
###   @11=1776177965
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=4
###   @9='UNI'
###   @10=1768075554
###   @11=1776177984
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 23220
#260414  8:46:24 server id 1  end_log_pos 23296 CRC32 0xdd9d260a 	Table_map: `marigas`.`caixa` mapped to number 99
# has_generated_invisible_primary_key=0
# at 23296
#260414  8:46:24 server id 1  end_log_pos 23407 CRC32 0x7243b701 	Write_rows: table id 99 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa`
### SET
###   @1=445
###   @2='2026:04:14'
###   @3=1
###   @4=120.00
###   @5='venda'
###   @6='Venda em dinheiro - Coleta #1205'
###   @7=1205
###   @8=1776177984
###   @9=1776177984
# at 23407
#260414  8:46:24 server id 1  end_log_pos 23438 CRC32 0x01a65ce1 	Xid = 3152
COMMIT/*!*/;
# at 23438
#260414  8:47:12 server id 1  end_log_pos 23517 CRC32 0x9ed40617 	Anonymous_GTID	last_committed=27	sequence_number=28	rbr_only=yes	original_committed_timestamp=1776167232868235	immediate_commit_timestamp=1776167232868235	transaction_length=1328
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167232868235 (2026-04-14 08:47:12.868235 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167232868235 (2026-04-14 08:47:12.868235 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167232868235*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 23517
#260414  8:47:12 server id 1  end_log_pos 23605 CRC32 0xd071320d 	Query	thread_id=252	exec_time=0	error_code=0
SET TIMESTAMP=1776167232/*!*/;
BEGIN
/*!*/;
# at 23605
#260414  8:47:12 server id 1  end_log_pos 23708 CRC32 0xed5405bd 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 23708
#260414  8:47:12 server id 1  end_log_pos 23893 CRC32 0x5fbfd6c7 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1206
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='MONOLUX - CONSTRUÇÕES CIVIS LTDA'
###   @8='AV . XV. DE NOVEMBRO'
###   @9='462 SALA 05/09'
###   @10='CENTRO'
###   @11='MARINGÁ'
###   @12=260
###   @13=NULL
###   @14=1776178032
###   @15=1776178032
###   @16=5
###   @17=4
###   @18=57.00
###   @19=3
# at 23893
#260414  8:47:12 server id 1  end_log_pos 23973 CRC32 0xfb4ac19c 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 23973
#260414  8:47:12 server id 1  end_log_pos 24055 CRC32 0x507f1c9c 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1219
###   @2=1206
###   @3=3
###   @4=3
###   @5=19.00
###   @6=57.00
###   @7=1776178032
###   @8=1776178032
# at 24055
#260414  8:47:12 server id 1  end_log_pos 24129 CRC32 0x5d936dfe 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 24129
#260414  8:47:12 server id 1  end_log_pos 24211 CRC32 0x6fc5dbe7 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1615
###   @2=3
###   @3=-3 (4294967293)
###   @4='saida'
###   @5='venda'
###   @6=1776178032
###   @7=1776178032
###   @8=1776178032
# at 24211
#260414  8:47:12 server id 1  end_log_pos 24302 CRC32 0x9ca2527b 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 24302
#260414  8:47:12 server id 1  end_log_pos 24526 CRC32 0x33f8dcec 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=43
###   @9='UNI'
###   @10=1768082861
###   @11=1776176490
###   @12=5
###   @13='7898116270607'
###   @14=1
### SET
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=40
###   @9='UNI'
###   @10=1768082861
###   @11=1776178032
###   @12=5
###   @13='7898116270607'
###   @14=1
# at 24526
#260414  8:47:12 server id 1  end_log_pos 24618 CRC32 0xff95ee40 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 24618
#260414  8:47:12 server id 1  end_log_pos 24735 CRC32 0x6b024b1c 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=857
###   @2=260
###   @3='Venda realizada - Coleta #1206'
###   @4=57.00
###   @5='2026:04:24'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=5
###   @10='4'
###   @11=NULL
###   @12=1776178032
###   @13=1776178032
# at 24735
#260414  8:47:12 server id 1  end_log_pos 24766 CRC32 0x4546b2eb 	Xid = 3328
COMMIT/*!*/;
# at 24766
#260414  8:48:02 server id 1  end_log_pos 24845 CRC32 0x79087a6c 	Anonymous_GTID	last_committed=28	sequence_number=29	rbr_only=yes	original_committed_timestamp=1776167282475134	immediate_commit_timestamp=1776167282475134	transaction_length=1292
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167282475134 (2026-04-14 08:48:02.475134 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167282475134 (2026-04-14 08:48:02.475134 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167282475134*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 24845
#260414  8:48:02 server id 1  end_log_pos 24933 CRC32 0xb44b8043 	Query	thread_id=261	exec_time=0	error_code=0
SET TIMESTAMP=1776167282/*!*/;
BEGIN
/*!*/;
# at 24933
#260414  8:48:02 server id 1  end_log_pos 25036 CRC32 0x24f85723 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 25036
#260414  8:48:02 server id 1  end_log_pos 25207 CRC32 0xa25b7a1e 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1207
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='VIZINHA DA DONA CICERA'
###   @8='VIELA JOAO TABORIANSKI'
###   @9='198'
###   @10='JARDIM QUEBEC'
###   @11='Maringá'
###   @12=1672
###   @13=NULL
###   @14=1776178082
###   @15=1776178082
###   @16=1
###   @17=1
###   @18=20.00
###   @19=1
# at 25207
#260414  8:48:02 server id 1  end_log_pos 25287 CRC32 0xf72d6138 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 25287
#260414  8:48:02 server id 1  end_log_pos 25369 CRC32 0xfd05d617 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1220
###   @2=1207
###   @3=3
###   @4=1
###   @5=19.00
###   @6=20.00
###   @7=1776178082
###   @8=1776178082
# at 25369
#260414  8:48:02 server id 1  end_log_pos 25443 CRC32 0x9d97cf5a 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 25443
#260414  8:48:02 server id 1  end_log_pos 25525 CRC32 0x296e9fb8 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1616
###   @2=3
###   @3=-1 (4294967295)
###   @4='saida'
###   @5='venda'
###   @6=1776178082
###   @7=1776178082
###   @8=1776178082
# at 25525
#260414  8:48:02 server id 1  end_log_pos 25616 CRC32 0x2d1adb7b 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 25616
#260414  8:48:02 server id 1  end_log_pos 25840 CRC32 0x50099f69 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=40
###   @9='UNI'
###   @10=1768082861
###   @11=1776178032
###   @12=5
###   @13='7898116270607'
###   @14=1
### SET
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=39
###   @9='UNI'
###   @10=1768082861
###   @11=1776178082
###   @12=5
###   @13='7898116270607'
###   @14=1
# at 25840
#260414  8:48:02 server id 1  end_log_pos 25916 CRC32 0x54dc5dde 	Table_map: `marigas`.`caixa` mapped to number 99
# has_generated_invisible_primary_key=0
# at 25916
#260414  8:48:02 server id 1  end_log_pos 26027 CRC32 0x6d49fa6a 	Write_rows: table id 99 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa`
### SET
###   @1=446
###   @2='2026:04:14'
###   @3=1
###   @4=20.00
###   @5='venda'
###   @6='Venda em dinheiro - Coleta #1207'
###   @7=1207
###   @8=1776178082
###   @9=1776178082
# at 26027
#260414  8:48:02 server id 1  end_log_pos 26058 CRC32 0xae255018 	Xid = 3486
COMMIT/*!*/;
# at 26058
#260414  8:49:18 server id 1  end_log_pos 26137 CRC32 0x4d6cc5ed 	Anonymous_GTID	last_committed=29	sequence_number=30	rbr_only=yes	original_committed_timestamp=1776167358563355	immediate_commit_timestamp=1776167358563355	transaction_length=1314
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167358563355 (2026-04-14 08:49:18.563355 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167358563355 (2026-04-14 08:49:18.563355 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167358563355*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 26137
#260414  8:49:18 server id 1  end_log_pos 26225 CRC32 0xc7147c66 	Query	thread_id=275	exec_time=0	error_code=0
SET TIMESTAMP=1776167358/*!*/;
BEGIN
/*!*/;
# at 26225
#260414  8:49:18 server id 1  end_log_pos 26328 CRC32 0xf0a47c93 	Table_map: `marigas`.`movimentacao` mapped to number 100
# has_generated_invisible_primary_key=0
# at 26328
#260414  8:49:18 server id 1  end_log_pos 26499 CRC32 0xa3353645 	Write_rows: table id 100 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao`
### SET
###   @1=1208
###   @2=NULL
###   @3=NULL
###   @4=1
###   @5='2026:04:14'
###   @6=NULL
###   @7='DONA CICERA DOS SANTOS'
###   @8='VIELA JOAO TABORIANSKI'
###   @9='211'
###   @10='JARDIM QUEBEC'
###   @11='MARINGÁ'
###   @12=26
###   @13=NULL
###   @14=1776178158
###   @15=1776178158
###   @16=4
###   @17=1
###   @18=38.00
###   @19=2
# at 26499
#260414  8:49:18 server id 1  end_log_pos 26579 CRC32 0x41e15ba9 	Table_map: `marigas`.`movimentacao_itens` mapped to number 102
# has_generated_invisible_primary_key=0
# at 26579
#260414  8:49:18 server id 1  end_log_pos 26661 CRC32 0x1723c593 	Write_rows: table id 102 flags: STMT_END_F
### INSERT INTO `marigas`.`movimentacao_itens`
### SET
###   @1=1221
###   @2=1208
###   @3=3
###   @4=2
###   @5=19.00
###   @6=38.00
###   @7=1776178158
###   @8=1776178158
# at 26661
#260414  8:49:18 server id 1  end_log_pos 26735 CRC32 0xb7f5707c 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 26735
#260414  8:49:18 server id 1  end_log_pos 26817 CRC32 0xbaacef9b 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1617
###   @2=3
###   @3=-2 (4294967294)
###   @4='saida'
###   @5='venda'
###   @6=1776178158
###   @7=1776178158
###   @8=1776178158
# at 26817
#260414  8:49:18 server id 1  end_log_pos 26908 CRC32 0x2f530572 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 26908
#260414  8:49:18 server id 1  end_log_pos 27132 CRC32 0x8047ec4c 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=39
###   @9='UNI'
###   @10=1768082861
###   @11=1776178082
###   @12=5
###   @13='7898116270607'
###   @14=1
### SET
###   @1=3
###   @2='GALÃO DE AGUA 20Lts'
###   @3=NULL
###   @4=9.50
###   @5=19.00
###   @6=100.00
###   @7=9.50
###   @8=37
###   @9='UNI'
###   @10=1768082861
###   @11=1776178158
###   @12=5
###   @13='7898116270607'
###   @14=1
# at 27132
#260414  8:49:18 server id 1  end_log_pos 27224 CRC32 0xa927c1de 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 27224
#260414  8:49:18 server id 1  end_log_pos 27341 CRC32 0xeba090cf 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=858
###   @2=26
###   @3='Venda realizada - Coleta #1208'
###   @4=38.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776178158
###   @13=1776178158
# at 27341
#260414  8:49:18 server id 1  end_log_pos 27372 CRC32 0x3ec3e590 	Xid = 3686
COMMIT/*!*/;
# at 27372
#260414  8:50:43 server id 1  end_log_pos 27451 CRC32 0xfbc0e295 	Anonymous_GTID	last_committed=30	sequence_number=31	rbr_only=yes	original_committed_timestamp=1776167443959438	immediate_commit_timestamp=1776167443959438	transaction_length=498
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167443959438 (2026-04-14 08:50:43.959438 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167443959438 (2026-04-14 08:50:43.959438 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167443959438*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 27451
#260414  8:50:43 server id 1  end_log_pos 27548 CRC32 0x50fd724f 	Query	thread_id=281	exec_time=0	error_code=0
SET TIMESTAMP=1776167443/*!*/;
BEGIN
/*!*/;
# at 27548
#260414  8:50:43 server id 1  end_log_pos 27639 CRC32 0xd4c9c75d 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 27639
#260414  8:50:43 server id 1  end_log_pos 27839 CRC32 0x565ea5e4 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=4
###   @9='UNI'
###   @10=1768075554
###   @11=1776177984
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=6
###   @9='UNI'
###   @10=1768075554
###   @11=1776178243
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 27839
#260414  8:50:43 server id 1  end_log_pos 27870 CRC32 0x016767e8 	Xid = 3819
COMMIT/*!*/;
# at 27870
#260414  8:53:57 server id 1  end_log_pos 27949 CRC32 0xe056c229 	Anonymous_GTID	last_committed=31	sequence_number=32	rbr_only=yes	original_committed_timestamp=1776167637655163	immediate_commit_timestamp=1776167637655163	transaction_length=1193
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167637655163 (2026-04-14 08:53:57.655163 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167637655163 (2026-04-14 08:53:57.655163 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167637655163*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 27949
#260414  8:53:57 server id 1  end_log_pos 28037 CRC32 0x0c8e32b7 	Query	thread_id=287	exec_time=0	error_code=0
SET TIMESTAMP=1776167637/*!*/;
BEGIN
/*!*/;
# at 28037
#260414  8:53:57 server id 1  end_log_pos 28122 CRC32 0x2df87b4b 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 28122
#260414  8:53:57 server id 1  end_log_pos 28237 CRC32 0x72851d26 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=411
###   @2=432
###   @3=248.12
###   @4=1776178437
###   @5=1776178437
###   @6=1
###   @7='CONTA ATRASADA'
###   @8=NULL
###   @9='2026:04:14'
###   @10='2026:04:15'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=2
# at 28237
#260414  8:53:57 server id 1  end_log_pos 28315 CRC32 0xed3b92da 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 28315
#260414  8:53:57 server id 1  end_log_pos 28397 CRC32 0xa3d709e1 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=411
###   @2=411
###   @3=4
###   @4=1
###   @5=248.12
###   @6=248.12
###   @7=1776178437
###   @8=1776178437
# at 28397
#260414  8:53:57 server id 1  end_log_pos 28471 CRC32 0xc4ba4e6e 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 28471
#260414  8:53:57 server id 1  end_log_pos 28556 CRC32 0x4fe5b747 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1618
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776178437
###   @7=1776178437
###   @8=1776178437
# at 28556
#260414  8:53:57 server id 1  end_log_pos 28647 CRC32 0xcecf8f6a 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 28647
#260414  8:53:57 server id 1  end_log_pos 28829 CRC32 0x6a4d0a11 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9894
###   @9='UNI'
###   @10=1768151301
###   @11=1776087214
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9895
###   @9='UNI'
###   @10=1768151301
###   @11=1776178437
###   @12=5
###   @13='999'
###   @14=NULL
# at 28829
#260414  8:53:57 server id 1  end_log_pos 28914 CRC32 0x4e4da22c 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 28914
#260414  8:53:57 server id 1  end_log_pos 29032 CRC32 0x983494ee 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=803
###   @2='2026:04:14'
###   @3=2
###   @4=248.12
###   @5='pix'
###   @6='compra'
###   @7='Compra via PIX - NF CONTA ATRASADA'
###   @8=411
###   @9=1776178437
###   @10=1776178437
# at 29032
#260414  8:53:57 server id 1  end_log_pos 29063 CRC32 0x05d3e9d8 	Xid = 3928
COMMIT/*!*/;
# at 29063
#260414  8:54:36 server id 1  end_log_pos 29142 CRC32 0xfbc7df64 	Anonymous_GTID	last_committed=32	sequence_number=33	rbr_only=yes	original_committed_timestamp=1776167676157272	immediate_commit_timestamp=1776167676157272	transaction_length=1167
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167676157272 (2026-04-14 08:54:36.157272 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167676157272 (2026-04-14 08:54:36.157272 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167676157272*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 29142
#260414  8:54:36 server id 1  end_log_pos 29230 CRC32 0xd6a47510 	Query	thread_id=290	exec_time=0	error_code=0
SET TIMESTAMP=1776167676/*!*/;
BEGIN
/*!*/;
# at 29230
#260414  8:54:36 server id 1  end_log_pos 29315 CRC32 0x6da5a08a 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 29315
#260414  8:54:36 server id 1  end_log_pos 29423 CRC32 0x56a13aee 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=412
###   @2=427
###   @3=25.00
###   @4=1776178476
###   @5=1776178476
###   @6=1
###   @7='COMPRAS'
###   @8=NULL
###   @9='2026:04:14'
###   @10='2026:04:15'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=1
# at 29423
#260414  8:54:36 server id 1  end_log_pos 29501 CRC32 0x92785556 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 29501
#260414  8:54:36 server id 1  end_log_pos 29583 CRC32 0x87ca28c3 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=412
###   @2=412
###   @3=4
###   @4=1
###   @5=25.00
###   @6=25.00
###   @7=1776178476
###   @8=1776178476
# at 29583
#260414  8:54:36 server id 1  end_log_pos 29657 CRC32 0x1ed9cb10 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 29657
#260414  8:54:36 server id 1  end_log_pos 29742 CRC32 0xd93976f7 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1619
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776178476
###   @7=1776178476
###   @8=1776178476
# at 29742
#260414  8:54:36 server id 1  end_log_pos 29833 CRC32 0x39e7e8fd 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 29833
#260414  8:54:36 server id 1  end_log_pos 30015 CRC32 0xafde463d 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9895
###   @9='UNI'
###   @10=1768151301
###   @11=1776178437
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9896
###   @9='UNI'
###   @10=1768151301
###   @11=1776178476
###   @12=5
###   @13='999'
###   @14=NULL
# at 30015
#260414  8:54:36 server id 1  end_log_pos 30091 CRC32 0xb2a88a78 	Table_map: `marigas`.`caixa` mapped to number 99
# has_generated_invisible_primary_key=0
# at 30091
#260414  8:54:36 server id 1  end_log_pos 30199 CRC32 0xb7d3b73e 	Write_rows: table id 99 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa`
### SET
###   @1=447
###   @2='2026:04:14'
###   @3=2
###   @4=25.00
###   @5='compra'
###   @6='Compra à vista - NF COMPRAS'
###   @7=412
###   @8=1776178476
###   @9=1776178476
# at 30199
#260414  8:54:36 server id 1  end_log_pos 30230 CRC32 0x7e224e9b 	Xid = 4002
COMMIT/*!*/;
# at 30230
#260414  8:55:18 server id 1  end_log_pos 30309 CRC32 0x113af4f4 	Anonymous_GTID	last_committed=33	sequence_number=34	rbr_only=yes	original_committed_timestamp=1776167718021564	immediate_commit_timestamp=1776167718021564	transaction_length=1179
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167718021564 (2026-04-14 08:55:18.021564 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167718021564 (2026-04-14 08:55:18.021564 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167718021564*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 30309
#260414  8:55:18 server id 1  end_log_pos 30397 CRC32 0xa67c1227 	Query	thread_id=293	exec_time=0	error_code=0
SET TIMESTAMP=1776167718/*!*/;
BEGIN
/*!*/;
# at 30397
#260414  8:55:18 server id 1  end_log_pos 30482 CRC32 0x991ee139 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 30482
#260414  8:55:18 server id 1  end_log_pos 30590 CRC32 0x0b8a1cc2 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=413
###   @2=416
###   @3=84.86
###   @4=1776178518
###   @5=1776178518
###   @6=1
###   @7='COMPRAS'
###   @8=NULL
###   @9='2026:04:14'
###   @10='2026:04:15'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=2
# at 30590
#260414  8:55:18 server id 1  end_log_pos 30668 CRC32 0xea1a0447 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 30668
#260414  8:55:18 server id 1  end_log_pos 30750 CRC32 0x52002ef6 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=413
###   @2=413
###   @3=4
###   @4=1
###   @5=84.86
###   @6=84.86
###   @7=1776178518
###   @8=1776178518
# at 30750
#260414  8:55:18 server id 1  end_log_pos 30824 CRC32 0xd5ee681a 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 30824
#260414  8:55:18 server id 1  end_log_pos 30909 CRC32 0xa7c43ce2 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1620
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776178518
###   @7=1776178518
###   @8=1776178518
# at 30909
#260414  8:55:18 server id 1  end_log_pos 31000 CRC32 0x6b32133c 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 31000
#260414  8:55:18 server id 1  end_log_pos 31182 CRC32 0x07eb2272 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9896
###   @9='UNI'
###   @10=1768151301
###   @11=1776178476
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9897
###   @9='UNI'
###   @10=1768151301
###   @11=1776178518
###   @12=5
###   @13='999'
###   @14=NULL
# at 31182
#260414  8:55:18 server id 1  end_log_pos 31267 CRC32 0x5cd79846 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 31267
#260414  8:55:18 server id 1  end_log_pos 31378 CRC32 0x4c4b643b 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=804
###   @2='2026:04:14'
###   @3=2
###   @4=84.86
###   @5='pix'
###   @6='compra'
###   @7='Compra via PIX - NF COMPRAS'
###   @8=413
###   @9=1776178518
###   @10=1776178518
# at 31378
#260414  8:55:18 server id 1  end_log_pos 31409 CRC32 0x69330cf1 	Xid = 4076
COMMIT/*!*/;
# at 31409
#260414  8:56:12 server id 1  end_log_pos 31488 CRC32 0xff396698 	Anonymous_GTID	last_committed=34	sequence_number=35	rbr_only=yes	original_committed_timestamp=1776167772344887	immediate_commit_timestamp=1776167772344887	transaction_length=1187
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167772344887 (2026-04-14 08:56:12.344887 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167772344887 (2026-04-14 08:56:12.344887 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167772344887*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 31488
#260414  8:56:12 server id 1  end_log_pos 31576 CRC32 0x85e307d5 	Query	thread_id=297	exec_time=0	error_code=0
SET TIMESTAMP=1776167772/*!*/;
BEGIN
/*!*/;
# at 31576
#260414  8:56:12 server id 1  end_log_pos 31661 CRC32 0x704953d5 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 31661
#260414  8:56:12 server id 1  end_log_pos 31779 CRC32 0x3c6798bb 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=414
###   @2=11
###   @3=33.50
###   @4=1776178572
###   @5=1776178572
###   @6=1
###   @7='DESPESAS DIVERSAS'
###   @8=NULL
###   @9='2026:04:14'
###   @10='2026:04:15'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=1
# at 31779
#260414  8:56:12 server id 1  end_log_pos 31857 CRC32 0xbf53d0e9 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 31857
#260414  8:56:12 server id 1  end_log_pos 31939 CRC32 0xbdfd3f72 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=414
###   @2=414
###   @3=4
###   @4=1
###   @5=33.50
###   @6=33.50
###   @7=1776178572
###   @8=1776178572
# at 31939
#260414  8:56:12 server id 1  end_log_pos 32013 CRC32 0xbb9436a8 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 32013
#260414  8:56:12 server id 1  end_log_pos 32098 CRC32 0xeb31a00b 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1621
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776178572
###   @7=1776178572
###   @8=1776178572
# at 32098
#260414  8:56:12 server id 1  end_log_pos 32189 CRC32 0xaedf4662 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 32189
#260414  8:56:12 server id 1  end_log_pos 32371 CRC32 0x0ab95fe2 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9897
###   @9='UNI'
###   @10=1768151301
###   @11=1776178518
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9898
###   @9='UNI'
###   @10=1768151301
###   @11=1776178572
###   @12=5
###   @13='999'
###   @14=NULL
# at 32371
#260414  8:56:12 server id 1  end_log_pos 32447 CRC32 0xe2f637ad 	Table_map: `marigas`.`caixa` mapped to number 99
# has_generated_invisible_primary_key=0
# at 32447
#260414  8:56:12 server id 1  end_log_pos 32565 CRC32 0x94af240e 	Write_rows: table id 99 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa`
### SET
###   @1=448
###   @2='2026:04:14'
###   @3=2
###   @4=33.50
###   @5='compra'
###   @6='Compra à vista - NF DESPESAS DIVERSAS'
###   @7=414
###   @8=1776178572
###   @9=1776178572
# at 32565
#260414  8:56:12 server id 1  end_log_pos 32596 CRC32 0x2b7f3db8 	Xid = 4189
COMMIT/*!*/;
# at 32596
#260414  8:57:52 server id 1  end_log_pos 32675 CRC32 0x7f3dbb79 	Anonymous_GTID	last_committed=35	sequence_number=36	rbr_only=yes	original_committed_timestamp=1776167872456571	immediate_commit_timestamp=1776167872456571	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167872456571 (2026-04-14 08:57:52.456571 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167872456571 (2026-04-14 08:57:52.456571 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167872456571*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 32675
#260414  8:57:52 server id 1  end_log_pos 32770 CRC32 0x0c718575 	Query	thread_id=305	exec_time=0	error_code=0
SET TIMESTAMP=1776167872/*!*/;
BEGIN
/*!*/;
# at 32770
#260414  8:57:52 server id 1  end_log_pos 32862 CRC32 0x76b0053c 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 32862
#260414  8:57:52 server id 1  end_log_pos 33065 CRC32 0xad95736b 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=826
###   @2=1547
###   @3='Venda realizada - Coleta #1154'
###   @4=115.00
###   @5='2026:04:12'
###   @6=NULL
###   @7='2026:04:11'
###   @8=1
###   @9=5
###   @10='1'
###   @11=NULL
###   @12=1775917339
###   @13=1775917339
### SET
###   @1=826
###   @2=1547
###   @3='Venda realizada - Coleta #1154'
###   @4=115.00
###   @5='2026:04:12'
###   @6='2026:04:14'
###   @7='2026:04:11'
###   @8=2
###   @9=2
###   @10='1'
###   @11=NULL
###   @12=1775917339
###   @13=1776178672
# at 33065
#260414  8:57:52 server id 1  end_log_pos 33150 CRC32 0x725a24d3 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 33150
#260414  8:57:52 server id 1  end_log_pos 33267 CRC32 0x5242b8e7 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=805
###   @2='2026:04:14'
###   @3=1
###   @4=115.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #826'
###   @8=826
###   @9=1776178672
###   @10=1776178672
# at 33267
#260414  8:57:52 server id 1  end_log_pos 33298 CRC32 0x88f51e8c 	Xid = 4350
COMMIT/*!*/;
# at 33298
#260414  8:58:16 server id 1  end_log_pos 33377 CRC32 0xb6579052 	Anonymous_GTID	last_committed=36	sequence_number=37	rbr_only=yes	original_committed_timestamp=1776167896514616	immediate_commit_timestamp=1776167896514616	transaction_length=397
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167896514616 (2026-04-14 08:58:16.514616 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167896514616 (2026-04-14 08:58:16.514616 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167896514616*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 33377
#260414  8:58:16 server id 1  end_log_pos 33455 CRC32 0xb7d62101 	Query	thread_id=309	exec_time=0	error_code=0
SET TIMESTAMP=1776167896/*!*/;
BEGIN
/*!*/;
# at 33455
#260414  8:58:16 server id 1  end_log_pos 33547 CRC32 0xf7ce5ad8 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 33547
#260414  8:58:16 server id 1  end_log_pos 33664 CRC32 0xcb944275 	Delete_rows: table id 91 flags: STMT_END_F
### DELETE FROM `marigas`.`contas_a_receber`
### WHERE
###   @1=843
###   @2=100
###   @3='Venda realizada - Coleta #1184'
###   @4=0.01
###   @5='2026:04:14'
###   @6=NULL
###   @7='2026:04:13'
###   @8=1
###   @9=5
###   @10='1'
###   @11=NULL
###   @12=1776085923
###   @13=1776085923
# at 33664
#260414  8:58:16 server id 1  end_log_pos 33695 CRC32 0x21cd69ec 	Xid = 4414
COMMIT/*!*/;
# at 33695
#260414  8:59:32 server id 1  end_log_pos 33774 CRC32 0xded3eed0 	Anonymous_GTID	last_committed=35	sequence_number=38	rbr_only=yes	original_committed_timestamp=1776167972074833	immediate_commit_timestamp=1776167972074833	transaction_length=383
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776167972074833 (2026-04-14 08:59:32.074833 Hora oficial do Brasil)
# immediate_commit_timestamp=1776167972074833 (2026-04-14 08:59:32.074833 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776167972074833*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 33774
#260414  8:59:32 server id 1  end_log_pos 33860 CRC32 0x5988dc0b 	Query	thread_id=314	exec_time=0	error_code=0
SET TIMESTAMP=1776167972/*!*/;
BEGIN
/*!*/;
# at 33860
#260414  8:59:32 server id 1  end_log_pos 33952 CRC32 0xe81fc150 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 33952
#260414  8:59:32 server id 1  end_log_pos 34047 CRC32 0xaf3ed673 	Write_rows: table id 91 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_receber`
### SET
###   @1=859
###   @2=1521
###   @3='ENTREGAS'
###   @4=33.62
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776178772
###   @13=1776178772
# at 34047
#260414  8:59:32 server id 1  end_log_pos 34078 CRC32 0x3f4fb5df 	Xid = 4486
COMMIT/*!*/;
# at 34078
#260414  9:03:16 server id 1  end_log_pos 34157 CRC32 0x2876f2a8 	Anonymous_GTID	last_committed=38	sequence_number=39	rbr_only=yes	original_committed_timestamp=1776168196645407	immediate_commit_timestamp=1776168196645407	transaction_length=700
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776168196645407 (2026-04-14 09:03:16.645407 Hora oficial do Brasil)
# immediate_commit_timestamp=1776168196645407 (2026-04-14 09:03:16.645407 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776168196645407*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 34157
#260414  9:03:16 server id 1  end_log_pos 34252 CRC32 0x433ad9ad 	Query	thread_id=321	exec_time=0	error_code=0
SET TIMESTAMP=1776168196/*!*/;
BEGIN
/*!*/;
# at 34252
#260414  9:03:16 server id 1  end_log_pos 34344 CRC32 0xb9264b1c 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 34344
#260414  9:03:16 server id 1  end_log_pos 34545 CRC32 0x6fdd2517 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=497
###   @2=42
###   @3='Venda realizada - Coleta #710'
###   @4=38.00
###   @5='2026:04:13'
###   @6=NULL
###   @7='2026:03:13'
###   @8=1
###   @9=4
###   @10='2'
###   @11=NULL
###   @12=1773413835
###   @13=1775919336
### SET
###   @1=497
###   @2=42
###   @3='Venda realizada - Coleta #710'
###   @4=38.00
###   @5='2026:04:13'
###   @6='2026:04:14'
###   @7='2026:03:13'
###   @8=2
###   @9=4
###   @10='2'
###   @11=NULL
###   @12=1773413835
###   @13=1776178996
# at 34545
#260414  9:03:16 server id 1  end_log_pos 34630 CRC32 0x362faeb1 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 34630
#260414  9:03:16 server id 1  end_log_pos 34747 CRC32 0xd5ce626f 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=806
###   @2='2026:04:14'
###   @3=1
###   @4=38.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #497'
###   @8=497
###   @9=1776178996
###   @10=1776178996
# at 34747
#260414  9:03:16 server id 1  end_log_pos 34778 CRC32 0xc3c0c784 	Xid = 4583
COMMIT/*!*/;
# at 34778
#260414  9:03:25 server id 1  end_log_pos 34857 CRC32 0x39162d85 	Anonymous_GTID	last_committed=39	sequence_number=40	rbr_only=yes	original_committed_timestamp=1776168205839636	immediate_commit_timestamp=1776168205839636	transaction_length=700
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776168205839636 (2026-04-14 09:03:25.839636 Hora oficial do Brasil)
# immediate_commit_timestamp=1776168205839636 (2026-04-14 09:03:25.839636 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776168205839636*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 34857
#260414  9:03:25 server id 1  end_log_pos 34952 CRC32 0x187a2e30 	Query	thread_id=324	exec_time=0	error_code=0
SET TIMESTAMP=1776168205/*!*/;
BEGIN
/*!*/;
# at 34952
#260414  9:03:25 server id 1  end_log_pos 35044 CRC32 0xa0d169ba 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 35044
#260414  9:03:25 server id 1  end_log_pos 35245 CRC32 0xd02af890 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=693
###   @2=1386
###   @3='Venda realizada - Coleta #977'
###   @4=120.00
###   @5='2026:04:13'
###   @6=NULL
###   @7='2026:03:30'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1774880254
###   @13=1775919404
### SET
###   @1=693
###   @2=1386
###   @3='Venda realizada - Coleta #977'
###   @4=120.00
###   @5='2026:04:13'
###   @6='2026:04:14'
###   @7='2026:03:30'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1774880254
###   @13=1776179005
# at 35245
#260414  9:03:25 server id 1  end_log_pos 35330 CRC32 0x8b292dba 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 35330
#260414  9:03:25 server id 1  end_log_pos 35447 CRC32 0x53e59cb9 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=807
###   @2='2026:04:14'
###   @3=1
###   @4=120.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #693'
###   @8=693
###   @9=1776179005
###   @10=1776179005
# at 35447
#260414  9:03:25 server id 1  end_log_pos 35478 CRC32 0x418702a4 	Xid = 4630
COMMIT/*!*/;
# at 35478
#260414  9:03:52 server id 1  end_log_pos 35557 CRC32 0x9463d9eb 	Anonymous_GTID	last_committed=40	sequence_number=41	rbr_only=yes	original_committed_timestamp=1776168232981657	immediate_commit_timestamp=1776168232981657	transaction_length=497
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776168232981657 (2026-04-14 09:03:52.981657 Hora oficial do Brasil)
# immediate_commit_timestamp=1776168232981657 (2026-04-14 09:03:52.981657 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776168232981657*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 35557
#260414  9:03:52 server id 1  end_log_pos 35652 CRC32 0x1e64f114 	Query	thread_id=327	exec_time=0	error_code=0
SET TIMESTAMP=1776168232/*!*/;
BEGIN
/*!*/;
# at 35652
#260414  9:03:52 server id 1  end_log_pos 35744 CRC32 0x9cf82e94 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 35744
#260414  9:03:52 server id 1  end_log_pos 35944 CRC32 0x9f9a6288 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=786
###   @2=26
###   @3='Venda realizada - Coleta #1103'
###   @4=19.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:07'
###   @8=1
###   @9=5
###   @10='1'
###   @11=NULL
###   @12=1775568340
###   @13=1776093326
### SET
###   @1=786
###   @2=26
###   @3='Venda realizada - Coleta #1103'
###   @4=19.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:07'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1775568340
###   @13=1776179032
# at 35944
#260414  9:03:52 server id 1  end_log_pos 35975 CRC32 0x7252d2e8 	Xid = 4677
COMMIT/*!*/;
# at 35975
#260414  9:05:01 server id 1  end_log_pos 36054 CRC32 0x4236cbb3 	Anonymous_GTID	last_committed=35	sequence_number=42	rbr_only=yes	original_committed_timestamp=1776168301678871	immediate_commit_timestamp=1776168301678871	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776168301678871 (2026-04-14 09:05:01.678871 Hora oficial do Brasil)
# immediate_commit_timestamp=1776168301678871 (2026-04-14 09:05:01.678871 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776168301678871*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 36054
#260414  9:05:01 server id 1  end_log_pos 36149 CRC32 0xbc1ed95d 	Query	thread_id=330	exec_time=0	error_code=0
SET TIMESTAMP=1776168301/*!*/;
BEGIN
/*!*/;
# at 36149
#260414  9:05:01 server id 1  end_log_pos 36241 CRC32 0x320555db 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 36241
#260414  9:05:01 server id 1  end_log_pos 36444 CRC32 0xfaf741b8 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=624
###   @2=260
###   @3='Venda realizada - Coleta #884'
###   @4=176.00
###   @5='2026:04:17'
###   @6=NULL
###   @7='2026:03:24'
###   @8=1
###   @9=3
###   @10='10'
###   @11=NULL
###   @12=1774402931
###   @13=1775490129
### SET
###   @1=624
###   @2=260
###   @3='Venda realizada - Coleta #884'
###   @4=176.00
###   @5='2026:04:17'
###   @6='2026:04:14'
###   @7='2026:03:24'
###   @8=2
###   @9=3
###   @10='10'
###   @11=NULL
###   @12=1774402931
###   @13=1776179101
# at 36444
#260414  9:05:01 server id 1  end_log_pos 36529 CRC32 0x6a18bac2 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 36529
#260414  9:05:01 server id 1  end_log_pos 36646 CRC32 0x92ccd821 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=808
###   @2='2026:04:14'
###   @3=1
###   @4=176.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #624'
###   @8=624
###   @9=1776179101
###   @10=1776179101
# at 36646
#260414  9:05:01 server id 1  end_log_pos 36677 CRC32 0xe54ec789 	Xid = 4718
COMMIT/*!*/;
# at 36677
#260414  9:10:18 server id 1  end_log_pos 36756 CRC32 0x41ac2a3e 	Anonymous_GTID	last_committed=41	sequence_number=43	rbr_only=yes	original_committed_timestamp=1776168618581933	immediate_commit_timestamp=1776168618581933	transaction_length=704
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776168618581933 (2026-04-14 09:10:18.581933 Hora oficial do Brasil)
# immediate_commit_timestamp=1776168618581933 (2026-04-14 09:10:18.581933 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776168618581933*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 36756
#260414  9:10:18 server id 1  end_log_pos 36851 CRC32 0x443125c2 	Query	thread_id=338	exec_time=0	error_code=0
SET TIMESTAMP=1776168618/*!*/;
BEGIN
/*!*/;
# at 36851
#260414  9:10:18 server id 1  end_log_pos 36943 CRC32 0x385cde6d 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 36943
#260414  9:10:18 server id 1  end_log_pos 37148 CRC32 0xe9178397 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=760
###   @2=1671
###   @3='Venda realizada - Coleta #1075'
###   @4=109.99
###   @5='2026:04:11'
###   @6=NULL
###   @7='2026:04:04'
###   @8=3
###   @9=5
###   @10='10'
###   @11=NULL
###   @12=1775314167
###   @13=1776097905
### SET
###   @1=760
###   @2=1671
###   @3='Venda realizada - Coleta #1075'
###   @4=126.87
###   @5='2026:04:11'
###   @6='2026:04:14'
###   @7='2026:04:04'
###   @8=2
###   @9=2
###   @10='10'
###   @11=NULL
###   @12=1775314167
###   @13=1776179418
# at 37148
#260414  9:10:18 server id 1  end_log_pos 37233 CRC32 0x7fe7d1e1 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 37233
#260414  9:10:18 server id 1  end_log_pos 37350 CRC32 0x84dca08c 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=809
###   @2='2026:04:14'
###   @3=1
###   @4=126.87
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #760'
###   @8=760
###   @9=1776179418
###   @10=1776179418
# at 37350
#260414  9:10:18 server id 1  end_log_pos 37381 CRC32 0x28dd1fe1 	Xid = 4864
COMMIT/*!*/;
# at 37381
#260414  9:10:49 server id 1  end_log_pos 37460 CRC32 0x94f9fe77 	Anonymous_GTID	last_committed=35	sequence_number=44	rbr_only=yes	original_committed_timestamp=1776168649794260	immediate_commit_timestamp=1776168649794260	transaction_length=385
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776168649794260 (2026-04-14 09:10:49.794260 Hora oficial do Brasil)
# immediate_commit_timestamp=1776168649794260 (2026-04-14 09:10:49.794260 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776168649794260*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 37460
#260414  9:10:49 server id 1  end_log_pos 37546 CRC32 0xd4478bdf 	Query	thread_id=341	exec_time=0	error_code=0
SET TIMESTAMP=1776168649/*!*/;
BEGIN
/*!*/;
# at 37546
#260414  9:10:49 server id 1  end_log_pos 37641 CRC32 0xdda0cb20 	Table_map: `marigas`.`fechamentos_caixa` mapped to number 97
# has_generated_invisible_primary_key=0
# at 37641
#260414  9:10:49 server id 1  end_log_pos 37735 CRC32 0x8e5592f0 	Write_rows: table id 97 flags: STMT_END_F
### INSERT INTO `marigas`.`fechamentos_caixa`
### SET
###   @1=56
###   @2='2026:04:14'
###   @3=1146.50
###   @4=1314.78
###   @5=391.48
###   @6=3447.18
###   @7=1250.00
###   @8=2197.18
###   @9='CAIXA'
###   @10=1776179449
###   @11=1776179449
# at 37735
#260414  9:10:49 server id 1  end_log_pos 37766 CRC32 0xafcb33b1 	Xid = 4955
COMMIT/*!*/;
# at 37766
#260414  9:10:49 server id 1  end_log_pos 37845 CRC32 0xe3bd9184 	Anonymous_GTID	last_committed=35	sequence_number=45	rbr_only=yes	original_committed_timestamp=1776168649796194	immediate_commit_timestamp=1776168649796194	transaction_length=414
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776168649796194 (2026-04-14 09:10:49.796194 Hora oficial do Brasil)
# immediate_commit_timestamp=1776168649796194 (2026-04-14 09:10:49.796194 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776168649796194*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 37845
#260414  9:10:49 server id 1  end_log_pos 37940 CRC32 0x94197879 	Query	thread_id=341	exec_time=0	error_code=0
SET TIMESTAMP=1776168649/*!*/;
BEGIN
/*!*/;
# at 37940
#260414  9:10:49 server id 1  end_log_pos 38021 CRC32 0x91f59601 	Table_map: `marigas`.`caixas_abertos` mapped to number 98
# has_generated_invisible_primary_key=0
# at 38021
#260414  9:10:49 server id 1  end_log_pos 38149 CRC32 0x763aaef8 	Update_rows: table id 98 flags: STMT_END_F
### UPDATE `marigas`.`caixas_abertos`
### WHERE
###   @1=60
###   @2='2026:04:14'
###   @3='2026-04-14 11:11:37'
###   @4=1
###   @5=1146.50
###   @6=1377.38
###   @7=1
###   @8=1776175897
###   @9=1776175897
### SET
###   @1=60
###   @2='2026:04:14'
###   @3='2026-04-14 11:11:37'
###   @4=1
###   @5=1146.50
###   @6=1377.38
###   @7=2
###   @8=1776175897
###   @9=1776179449
# at 38149
#260414  9:10:49 server id 1  end_log_pos 38180 CRC32 0xe8b7b19f 	Xid = 4958
COMMIT/*!*/;
# at 38180
#260415  9:12:46 server id 1  end_log_pos 38259 CRC32 0x7ee9d8ee 	Anonymous_GTID	last_committed=35	sequence_number=46	rbr_only=yes	original_committed_timestamp=1776255166267319	immediate_commit_timestamp=1776255166267319	transaction_length=358
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255166267319 (2026-04-15 09:12:46.267319 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255166267319 (2026-04-15 09:12:46.267319 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255166267319*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 38259
#260415  9:12:46 server id 1  end_log_pos 38345 CRC32 0x4016fa57 	Query	thread_id=349	exec_time=0	error_code=0
SET TIMESTAMP=1776255166/*!*/;
BEGIN
/*!*/;
# at 38345
#260415  9:12:46 server id 1  end_log_pos 38426 CRC32 0x67fc3883 	Table_map: `marigas`.`caixas_abertos` mapped to number 98
# has_generated_invisible_primary_key=0
# at 38426
#260415  9:12:46 server id 1  end_log_pos 38507 CRC32 0xdfc9a001 	Write_rows: table id 98 flags: STMT_END_F
### INSERT INTO `marigas`.`caixas_abertos`
### SET
###   @1=61
###   @2='2026:04:15'
###   @3='2026-04-15 12:12:46'
###   @4=1
###   @5=1250.00
###   @6=2197.18
###   @7=1
###   @8=1776265966
###   @9=1776265966
# at 38507
#260415  9:12:46 server id 1  end_log_pos 38538 CRC32 0xae9a5eff 	Xid = 5018
COMMIT/*!*/;
# at 38538
#260415  9:13:20 server id 1  end_log_pos 38617 CRC32 0x46c62002 	Anonymous_GTID	last_committed=41	sequence_number=47	rbr_only=yes	original_committed_timestamp=1776255200166920	immediate_commit_timestamp=1776255200166920	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255200166920 (2026-04-15 09:13:20.166920 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255200166920 (2026-04-15 09:13:20.166920 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255200166920*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 38617
#260415  9:13:20 server id 1  end_log_pos 38712 CRC32 0x0af11109 	Query	thread_id=354	exec_time=0	error_code=0
SET TIMESTAMP=1776255200/*!*/;
BEGIN
/*!*/;
# at 38712
#260415  9:13:20 server id 1  end_log_pos 38804 CRC32 0x984711ac 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 38804
#260415  9:13:20 server id 1  end_log_pos 39007 CRC32 0xa1aeb30f 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=850
###   @2=486
###   @3='Venda realizada - Coleta #1197'
###   @4=19.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176323
###   @13=1776176323
### SET
###   @1=850
###   @2=486
###   @3='Venda realizada - Coleta #1197'
###   @4=19.00
###   @5='2026:04:15'
###   @6='2026:04:15'
###   @7='2026:04:14'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176323
###   @13=1776266000
# at 39007
#260415  9:13:20 server id 1  end_log_pos 39092 CRC32 0x663e906a 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 39092
#260415  9:13:20 server id 1  end_log_pos 39209 CRC32 0xec68d537 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=810
###   @2='2026:04:15'
###   @3=1
###   @4=19.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #850'
###   @8=850
###   @9=1776266000
###   @10=1776266000
# at 39209
#260415  9:13:20 server id 1  end_log_pos 39240 CRC32 0x21896e6e 	Xid = 5109
COMMIT/*!*/;
# at 39240
#260415  9:13:28 server id 1  end_log_pos 39319 CRC32 0x5574f458 	Anonymous_GTID	last_committed=47	sequence_number=48	rbr_only=yes	original_committed_timestamp=1776255208083479	immediate_commit_timestamp=1776255208083479	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255208083479 (2026-04-15 09:13:28.083479 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255208083479 (2026-04-15 09:13:28.083479 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255208083479*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 39319
#260415  9:13:28 server id 1  end_log_pos 39414 CRC32 0x4fd3e6a2 	Query	thread_id=357	exec_time=0	error_code=0
SET TIMESTAMP=1776255208/*!*/;
BEGIN
/*!*/;
# at 39414
#260415  9:13:28 server id 1  end_log_pos 39506 CRC32 0x882af228 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 39506
#260415  9:13:28 server id 1  end_log_pos 39709 CRC32 0x31ee9e9d 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=852
###   @2=376
###   @3='Venda realizada - Coleta #1200'
###   @4=118.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176471
###   @13=1776176471
### SET
###   @1=852
###   @2=376
###   @3='Venda realizada - Coleta #1200'
###   @4=118.00
###   @5='2026:04:15'
###   @6='2026:04:15'
###   @7='2026:04:14'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176471
###   @13=1776266008
# at 39709
#260415  9:13:28 server id 1  end_log_pos 39794 CRC32 0x126d706e 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 39794
#260415  9:13:28 server id 1  end_log_pos 39911 CRC32 0xe64b69c6 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=811
###   @2='2026:04:15'
###   @3=1
###   @4=118.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #852'
###   @8=852
###   @9=1776266008
###   @10=1776266008
# at 39911
#260415  9:13:28 server id 1  end_log_pos 39942 CRC32 0x7b16e18a 	Xid = 5156
COMMIT/*!*/;
# at 39942
#260415  9:13:35 server id 1  end_log_pos 40021 CRC32 0xe40ca984 	Anonymous_GTID	last_committed=48	sequence_number=49	rbr_only=yes	original_committed_timestamp=1776255215698634	immediate_commit_timestamp=1776255215698634	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255215698634 (2026-04-15 09:13:35.698634 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255215698634 (2026-04-15 09:13:35.698634 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255215698634*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 40021
#260415  9:13:35 server id 1  end_log_pos 40116 CRC32 0xe53237da 	Query	thread_id=360	exec_time=0	error_code=0
SET TIMESTAMP=1776255215/*!*/;
BEGIN
/*!*/;
# at 40116
#260415  9:13:35 server id 1  end_log_pos 40208 CRC32 0xac0613f9 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 40208
#260415  9:13:35 server id 1  end_log_pos 40411 CRC32 0x39b6135d 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=856
###   @2=1687
###   @3='Venda realizada - Coleta #1204'
###   @4=118.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776177965
###   @13=1776177965
### SET
###   @1=856
###   @2=1687
###   @3='Venda realizada - Coleta #1204'
###   @4=118.00
###   @5='2026:04:15'
###   @6='2026:04:15'
###   @7='2026:04:14'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776177965
###   @13=1776266015
# at 40411
#260415  9:13:35 server id 1  end_log_pos 40496 CRC32 0xf4a708df 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 40496
#260415  9:13:35 server id 1  end_log_pos 40613 CRC32 0x2e32f507 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=812
###   @2='2026:04:15'
###   @3=1
###   @4=118.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #856'
###   @8=856
###   @9=1776266015
###   @10=1776266015
# at 40613
#260415  9:13:35 server id 1  end_log_pos 40644 CRC32 0x4cae5670 	Xid = 5203
COMMIT/*!*/;
# at 40644
#260415  9:13:42 server id 1  end_log_pos 40723 CRC32 0x55bd7943 	Anonymous_GTID	last_committed=49	sequence_number=50	rbr_only=yes	original_committed_timestamp=1776255222910009	immediate_commit_timestamp=1776255222910009	transaction_length=658
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255222910009 (2026-04-15 09:13:42.910009 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255222910009 (2026-04-15 09:13:42.910009 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255222910009*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 40723
#260415  9:13:42 server id 1  end_log_pos 40818 CRC32 0x4fd90e5a 	Query	thread_id=363	exec_time=0	error_code=0
SET TIMESTAMP=1776255222/*!*/;
BEGIN
/*!*/;
# at 40818
#260415  9:13:42 server id 1  end_log_pos 40910 CRC32 0x534dfdd8 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 40910
#260415  9:13:42 server id 1  end_log_pos 41069 CRC32 0xab988591 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=859
###   @2=1521
###   @3='ENTREGAS'
###   @4=33.62
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776178772
###   @13=1776178772
### SET
###   @1=859
###   @2=1521
###   @3='ENTREGAS'
###   @4=33.62
###   @5='2026:04:15'
###   @6='2026:04:15'
###   @7='2026:04:14'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776178772
###   @13=1776266022
# at 41069
#260415  9:13:42 server id 1  end_log_pos 41154 CRC32 0x48373351 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 41154
#260415  9:13:42 server id 1  end_log_pos 41271 CRC32 0xa0f9517e 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=813
###   @2='2026:04:15'
###   @3=1
###   @4=33.62
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #859'
###   @8=859
###   @9=1776266022
###   @10=1776266022
# at 41271
#260415  9:13:42 server id 1  end_log_pos 41302 CRC32 0x50c56955 	Xid = 5250
COMMIT/*!*/;
# at 41302
#260415  9:13:52 server id 1  end_log_pos 41381 CRC32 0xe473eabd 	Anonymous_GTID	last_committed=50	sequence_number=51	rbr_only=yes	original_committed_timestamp=1776255232367954	immediate_commit_timestamp=1776255232367954	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255232367954 (2026-04-15 09:13:52.367954 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255232367954 (2026-04-15 09:13:52.367954 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255232367954*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 41381
#260415  9:13:52 server id 1  end_log_pos 41476 CRC32 0xe9d88cb9 	Query	thread_id=366	exec_time=0	error_code=0
SET TIMESTAMP=1776255232/*!*/;
BEGIN
/*!*/;
# at 41476
#260415  9:13:52 server id 1  end_log_pos 41568 CRC32 0xb93a551a 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 41568
#260415  9:13:52 server id 1  end_log_pos 41771 CRC32 0x837ed0a9 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=858
###   @2=26
###   @3='Venda realizada - Coleta #1208'
###   @4=38.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776178158
###   @13=1776178158
### SET
###   @1=858
###   @2=26
###   @3='Venda realizada - Coleta #1208'
###   @4=38.00
###   @5='2026:04:15'
###   @6='2026:04:15'
###   @7='2026:04:14'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776178158
###   @13=1776266032
# at 41771
#260415  9:13:52 server id 1  end_log_pos 41856 CRC32 0x6bf8d5f4 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 41856
#260415  9:13:52 server id 1  end_log_pos 41973 CRC32 0xa0a5a6db 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=814
###   @2='2026:04:15'
###   @3=1
###   @4=38.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #858'
###   @8=858
###   @9=1776266032
###   @10=1776266032
# at 41973
#260415  9:13:52 server id 1  end_log_pos 42004 CRC32 0x63334055 	Xid = 5297
COMMIT/*!*/;
# at 42004
#260415  9:14:00 server id 1  end_log_pos 42083 CRC32 0xebc264da 	Anonymous_GTID	last_committed=51	sequence_number=52	rbr_only=yes	original_committed_timestamp=1776255240277188	immediate_commit_timestamp=1776255240277188	transaction_length=702
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255240277188 (2026-04-15 09:14:00.277188 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255240277188 (2026-04-15 09:14:00.277188 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255240277188*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 42083
#260415  9:14:00 server id 1  end_log_pos 42178 CRC32 0x05ffa502 	Query	thread_id=369	exec_time=0	error_code=0
SET TIMESTAMP=1776255240/*!*/;
BEGIN
/*!*/;
# at 42178
#260415  9:14:00 server id 1  end_log_pos 42270 CRC32 0x6e61e73e 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 42270
#260415  9:14:00 server id 1  end_log_pos 42473 CRC32 0x07356e28 	Update_rows: table id 91 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_receber`
### WHERE
###   @1=855
###   @2=737
###   @3='Venda realizada - Coleta #1203'
###   @4=118.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:14'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176896
###   @13=1776176896
### SET
###   @1=855
###   @2=737
###   @3='Venda realizada - Coleta #1203'
###   @4=118.00
###   @5='2026:04:15'
###   @6='2026:04:15'
###   @7='2026:04:14'
###   @8=2
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1776176896
###   @13=1776266040
# at 42473
#260415  9:14:00 server id 1  end_log_pos 42558 CRC32 0xce5775c8 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 42558
#260415  9:14:00 server id 1  end_log_pos 42675 CRC32 0x566a3e20 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=815
###   @2='2026:04:15'
###   @3=1
###   @4=118.00
###   @5=NULL
###   @6='recebimento'
###   @7='Recebimento conta a receber #855'
###   @8=855
###   @9=1776266040
###   @10=1776266040
# at 42675
#260415  9:14:00 server id 1  end_log_pos 42706 CRC32 0x62698369 	Xid = 5344
COMMIT/*!*/;
# at 42706
#260415  9:14:51 server id 1  end_log_pos 42785 CRC32 0x2ab3e56c 	Anonymous_GTID	last_committed=52	sequence_number=53	rbr_only=yes	original_committed_timestamp=1776255291061319	immediate_commit_timestamp=1776255291061319	transaction_length=397
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255291061319 (2026-04-15 09:14:51.061319 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255291061319 (2026-04-15 09:14:51.061319 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255291061319*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 42785
#260415  9:14:51 server id 1  end_log_pos 42863 CRC32 0x209737e3 	Query	thread_id=373	exec_time=0	error_code=0
SET TIMESTAMP=1776255291/*!*/;
BEGIN
/*!*/;
# at 42863
#260415  9:14:51 server id 1  end_log_pos 42955 CRC32 0x45be9c82 	Table_map: `marigas`.`contas_a_receber` mapped to number 91
# has_generated_invisible_primary_key=0
# at 42955
#260415  9:14:51 server id 1  end_log_pos 43072 CRC32 0x02c905ab 	Delete_rows: table id 91 flags: STMT_END_F
### DELETE FROM `marigas`.`contas_a_receber`
### WHERE
###   @1=786
###   @2=26
###   @3='Venda realizada - Coleta #1103'
###   @4=19.00
###   @5='2026:04:15'
###   @6=NULL
###   @7='2026:04:07'
###   @8=1
###   @9=4
###   @10='1'
###   @11=NULL
###   @12=1775568340
###   @13=1776179032
# at 43072
#260415  9:14:51 server id 1  end_log_pos 43103 CRC32 0x1f40ba89 	Xid = 5426
COMMIT/*!*/;
# at 43103
#260415  9:15:16 server id 1  end_log_pos 43182 CRC32 0x4ed2a851 	Anonymous_GTID	last_committed=43	sequence_number=54	rbr_only=yes	original_committed_timestamp=1776255316182280	immediate_commit_timestamp=1776255316182280	transaction_length=2048
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255316182280 (2026-04-15 09:15:16.182280 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255316182280 (2026-04-15 09:15:16.182280 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255316182280*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 43182
#260415  9:15:16 server id 1  end_log_pos 43277 CRC32 0xa145e590 	Query	thread_id=376	exec_time=0	error_code=0
SET TIMESTAMP=1776255316/*!*/;
BEGIN
/*!*/;
# at 43277
#260415  9:15:16 server id 1  end_log_pos 43368 CRC32 0x2e65a6b6 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 43368
#260415  9:15:16 server id 1  end_log_pos 45120 CRC32 0xcaccac69 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776101626
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776266116
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776101626
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776266116
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6839
###   @2=428
###   @3='DESPESAS DIVERSAS'
###   @4=100.00
###   @5='2026:03:19'
###   @6='2026:04:14'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 428'
###   @11=1774030440
###   @12=1774030440
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6839
###   @2=428
###   @3='DESPESAS DIVERSAS'
###   @4=100.00
###   @5='2026:03:19'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 428'
###   @11=1774030440
###   @12=1776266116
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776099261
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776266116
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776099071
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776101626
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1775584675
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 45120
#260415  9:15:16 server id 1  end_log_pos 45151 CRC32 0x6d97054b 	Xid = 5456
COMMIT/*!*/;
# at 45151
#260415  9:15:16 server id 1  end_log_pos 45230 CRC32 0x8decf975 	Anonymous_GTID	last_committed=54	sequence_number=55	rbr_only=yes	original_committed_timestamp=1776255316185392	immediate_commit_timestamp=1776255316185392	transaction_length=942
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255316185392 (2026-04-15 09:15:16.185392 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255316185392 (2026-04-15 09:15:16.185392 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255316185392*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 45230
#260415  9:15:16 server id 1  end_log_pos 45325 CRC32 0xb064cb6e 	Query	thread_id=376	exec_time=0	error_code=0
SET TIMESTAMP=1776255316/*!*/;
BEGIN
/*!*/;
# at 45325
#260415  9:15:16 server id 1  end_log_pos 45416 CRC32 0x81ffab6b 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 45416
#260415  9:15:16 server id 1  end_log_pos 46062 CRC32 0x36ae51bf 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6767
###   @2=440
###   @3='31  AGUA'
###   @4=561.80
###   @5='2026:03:12'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1773337019
###   @12=1776099031
###   @13=1
###   @14=262
###   @15=1
###   @16=1
### SET
###   @1=6767
###   @2=440
###   @3='31  AGUA'
###   @4=561.80
###   @5='2026:03:12'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1773337019
###   @12=1776266116
###   @13=1
###   @14=262
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776099080
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1775584675
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 46062
#260415  9:15:16 server id 1  end_log_pos 46093 CRC32 0xe5c4670e 	Xid = 5459
COMMIT/*!*/;
# at 46093
#260415  9:16:00 server id 1  end_log_pos 46172 CRC32 0xaeeec4a3 	Anonymous_GTID	last_committed=55	sequence_number=56	rbr_only=yes	original_committed_timestamp=1776255360024825	immediate_commit_timestamp=1776255360024825	transaction_length=486
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255360024825 (2026-04-15 09:16:00.024825 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255360024825 (2026-04-15 09:16:00.024825 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255360024825*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 46172
#260415  9:16:00 server id 1  end_log_pos 46267 CRC32 0xc8a05c7c 	Query	thread_id=378	exec_time=0	error_code=0
SET TIMESTAMP=1776255360/*!*/;
BEGIN
/*!*/;
# at 46267
#260415  9:16:00 server id 1  end_log_pos 46358 CRC32 0xf851feec 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 46358
#260415  9:16:00 server id 1  end_log_pos 46548 CRC32 0x017bc40f 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6767
###   @2=440
###   @3='31  AGUA'
###   @4=561.80
###   @5='2026:03:12'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1773337019
###   @12=1776266116
###   @13=1
###   @14=262
###   @15=1
###   @16=1
### SET
###   @1=6767
###   @2=440
###   @3='31  AGUA'
###   @4=712.88
###   @5='2026:03:12'
###   @6='2026:04:16'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1773337019
###   @12=1776266160
###   @13=1
###   @14=262
###   @15=1
###   @16=1
# at 46548
#260415  9:16:00 server id 1  end_log_pos 46579 CRC32 0x58aef46d 	Xid = 7488
COMMIT/*!*/;
# at 46579
#260415  9:16:00 server id 1  end_log_pos 46658 CRC32 0xd7b77b0a 	Anonymous_GTID	last_committed=56	sequence_number=57	rbr_only=yes	original_committed_timestamp=1776255360177893	immediate_commit_timestamp=1776255360177893	transaction_length=2048
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255360177893 (2026-04-15 09:16:00.177893 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255360177893 (2026-04-15 09:16:00.177893 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255360177893*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 46658
#260415  9:16:00 server id 1  end_log_pos 46753 CRC32 0x442763a3 	Query	thread_id=379	exec_time=0	error_code=0
SET TIMESTAMP=1776255360/*!*/;
BEGIN
/*!*/;
# at 46753
#260415  9:16:00 server id 1  end_log_pos 46844 CRC32 0x57113881 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 46844
#260415  9:16:00 server id 1  end_log_pos 48596 CRC32 0xf1c898f1 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776266116
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776266160
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776266116
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776266160
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6839
###   @2=428
###   @3='DESPESAS DIVERSAS'
###   @4=100.00
###   @5='2026:03:19'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 428'
###   @11=1774030440
###   @12=1776266116
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6839
###   @2=428
###   @3='DESPESAS DIVERSAS'
###   @4=100.00
###   @5='2026:03:19'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 428'
###   @11=1774030440
###   @12=1776266160
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776266116
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776266160
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 48596
#260415  9:16:00 server id 1  end_log_pos 48627 CRC32 0x936d3bc8 	Xid = 7498
COMMIT/*!*/;
# at 48627
#260415  9:16:00 server id 1  end_log_pos 48706 CRC32 0x0918859e 	Anonymous_GTID	last_committed=57	sequence_number=58	rbr_only=yes	original_committed_timestamp=1776255360180662	immediate_commit_timestamp=1776255360180662	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255360180662 (2026-04-15 09:16:00.180662 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255360180662 (2026-04-15 09:16:00.180662 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255360180662*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 48706
#260415  9:16:00 server id 1  end_log_pos 48801 CRC32 0xfde88436 	Query	thread_id=379	exec_time=0	error_code=0
SET TIMESTAMP=1776255360/*!*/;
BEGIN
/*!*/;
# at 48801
#260415  9:16:00 server id 1  end_log_pos 48892 CRC32 0x84b7c1f5 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 48892
#260415  9:16:00 server id 1  end_log_pos 49386 CRC32 0xa2a6a0ee 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266116
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 49386
#260415  9:16:00 server id 1  end_log_pos 49417 CRC32 0x02cd7192 	Xid = 7501
COMMIT/*!*/;
# at 49417
#260415  9:16:13 server id 1  end_log_pos 49496 CRC32 0x2be1ecda 	Anonymous_GTID	last_committed=58	sequence_number=59	rbr_only=yes	original_committed_timestamp=1776255373050113	immediate_commit_timestamp=1776255373050113	transaction_length=440
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255373050113 (2026-04-15 09:16:13.050113 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255373050113 (2026-04-15 09:16:13.050113 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255373050113*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 49496
#260415  9:16:13 server id 1  end_log_pos 49574 CRC32 0x2b3097ef 	Query	thread_id=380	exec_time=0	error_code=0
SET TIMESTAMP=1776255373/*!*/;
BEGIN
/*!*/;
# at 49574
#260415  9:16:13 server id 1  end_log_pos 49665 CRC32 0x934e15e1 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 49665
#260415  9:16:13 server id 1  end_log_pos 49826 CRC32 0x5d0065ef 	Delete_rows: table id 90 flags: STMT_END_F
### DELETE FROM `marigas`.`contas_a_pagar`
### WHERE
###   @1=6839
###   @2=428
###   @3='DESPESAS DIVERSAS'
###   @4=100.00
###   @5='2026:03:19'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 428'
###   @11=1774030440
###   @12=1776266160
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
# at 49826
#260415  9:16:13 server id 1  end_log_pos 49857 CRC32 0xc279ff60 	Xid = 9514
COMMIT/*!*/;
# at 49857
#260415  9:16:13 server id 1  end_log_pos 49936 CRC32 0x52e42e11 	Anonymous_GTID	last_committed=59	sequence_number=60	rbr_only=yes	original_committed_timestamp=1776255373205506	immediate_commit_timestamp=1776255373205506	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255373205506 (2026-04-15 09:16:13.205506 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255373205506 (2026-04-15 09:16:13.205506 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255373205506*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 49936
#260415  9:16:13 server id 1  end_log_pos 50031 CRC32 0x14357c85 	Query	thread_id=381	exec_time=0	error_code=0
SET TIMESTAMP=1776255373/*!*/;
BEGIN
/*!*/;
# at 50031
#260415  9:16:13 server id 1  end_log_pos 50122 CRC32 0x6a35c5bb 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 50122
#260415  9:16:13 server id 1  end_log_pos 51624 CRC32 0x2a93a284 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776266160
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776266173
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776266160
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776266173
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776266160
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776266173
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 51624
#260415  9:16:13 server id 1  end_log_pos 51655 CRC32 0x30092696 	Xid = 9520
COMMIT/*!*/;
# at 51655
#260415  9:16:13 server id 1  end_log_pos 51734 CRC32 0x0e653d0f 	Anonymous_GTID	last_committed=60	sequence_number=61	rbr_only=yes	original_committed_timestamp=1776255373208305	immediate_commit_timestamp=1776255373208305	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255373208305 (2026-04-15 09:16:13.208305 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255373208305 (2026-04-15 09:16:13.208305 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255373208305*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 51734
#260415  9:16:13 server id 1  end_log_pos 51829 CRC32 0x16361034 	Query	thread_id=381	exec_time=0	error_code=0
SET TIMESTAMP=1776255373/*!*/;
BEGIN
/*!*/;
# at 51829
#260415  9:16:13 server id 1  end_log_pos 51920 CRC32 0xa37c9052 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 51920
#260415  9:16:13 server id 1  end_log_pos 52414 CRC32 0x8170b441 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266160
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 52414
#260415  9:16:13 server id 1  end_log_pos 52445 CRC32 0x172c7491 	Xid = 9523
COMMIT/*!*/;
# at 52445
#260415  9:16:38 server id 1  end_log_pos 52524 CRC32 0xeea30aad 	Anonymous_GTID	last_committed=61	sequence_number=62	rbr_only=yes	original_committed_timestamp=1776255398730051	immediate_commit_timestamp=1776255398730051	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255398730051 (2026-04-15 09:16:38.730051 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255398730051 (2026-04-15 09:16:38.730051 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255398730051*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 52524
#260415  9:16:38 server id 1  end_log_pos 52619 CRC32 0x6d535991 	Query	thread_id=382	exec_time=0	error_code=0
SET TIMESTAMP=1776255398/*!*/;
BEGIN
/*!*/;
# at 52619
#260415  9:16:38 server id 1  end_log_pos 52710 CRC32 0x3a10584c 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 52710
#260415  9:16:38 server id 1  end_log_pos 54212 CRC32 0x81deadfe 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776266173
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776266198
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776266173
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776266198
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776266173
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776266198
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 54212
#260415  9:16:38 server id 1  end_log_pos 54243 CRC32 0x1b81a849 	Xid = 11527
COMMIT/*!*/;
# at 54243
#260415  9:16:38 server id 1  end_log_pos 54322 CRC32 0x451742aa 	Anonymous_GTID	last_committed=62	sequence_number=63	rbr_only=yes	original_committed_timestamp=1776255398733219	immediate_commit_timestamp=1776255398733219	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255398733219 (2026-04-15 09:16:38.733219 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255398733219 (2026-04-15 09:16:38.733219 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255398733219*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 54322
#260415  9:16:38 server id 1  end_log_pos 54417 CRC32 0xc7befc4b 	Query	thread_id=382	exec_time=0	error_code=0
SET TIMESTAMP=1776255398/*!*/;
BEGIN
/*!*/;
# at 54417
#260415  9:16:38 server id 1  end_log_pos 54508 CRC32 0x2013deb4 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 54508
#260415  9:16:38 server id 1  end_log_pos 55002 CRC32 0x1faf8384 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266173
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 55002
#260415  9:16:38 server id 1  end_log_pos 55033 CRC32 0x292ee87c 	Xid = 11530
COMMIT/*!*/;
# at 55033
#260415  9:17:44 server id 1  end_log_pos 55112 CRC32 0x4b9d660e 	Anonymous_GTID	last_committed=63	sequence_number=64	rbr_only=yes	original_committed_timestamp=1776255464408465	immediate_commit_timestamp=1776255464408465	transaction_length=1263
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776255464408465 (2026-04-15 09:17:44.408465 Hora oficial do Brasil)
# immediate_commit_timestamp=1776255464408465 (2026-04-15 09:17:44.408465 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776255464408465*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 55112
#260415  9:17:44 server id 1  end_log_pos 55200 CRC32 0x29642cc0 	Query	thread_id=385	exec_time=0	error_code=0
SET TIMESTAMP=1776255464/*!*/;
BEGIN
/*!*/;
# at 55200
#260415  9:17:44 server id 1  end_log_pos 55285 CRC32 0xf844d9e4 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 55285
#260415  9:17:44 server id 1  end_log_pos 55404 CRC32 0x8b503a85 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=415
###   @2=2
###   @3=2112.00
###   @4=1776266264
###   @5=1776266264
###   @6=9
###   @7='22 GÁS NF. 57.740'
###   @8=NULL
###   @9='2026:04:15'
###   @10='2026:04:20'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=5
# at 55404
#260415  9:17:44 server id 1  end_log_pos 55482 CRC32 0xae908df3 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 55482
#260415  9:17:44 server id 1  end_log_pos 55564 CRC32 0x04534663 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=415
###   @2=415
###   @3=2
###   @4=22
###   @5=96.00
###   @6=2112.00
###   @7=1776266264
###   @8=1776266264
# at 55564
#260415  9:17:44 server id 1  end_log_pos 55638 CRC32 0x0e8fd166 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 55638
#260415  9:17:44 server id 1  end_log_pos 55723 CRC32 0x2395cb87 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1622
###   @2=2
###   @3=22
###   @4='entrada'
###   @5='compra'
###   @6=1776266264
###   @7=1776266264
###   @8=1776266264
# at 55723
#260415  9:17:44 server id 1  end_log_pos 55814 CRC32 0x4bf16522 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 55814
#260415  9:17:44 server id 1  end_log_pos 56014 CRC32 0x217c0161 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=6
###   @9='UNI'
###   @10=1768075554
###   @11=1776178243
###   @12=3
###   @13='7898960399165'
###   @14=1
### SET
###   @1=2
###   @2='GAS P-13'
###   @3=NULL
###   @4=96.00
###   @5=118.00
###   @6=22.92
###   @7=22.00
###   @8=28
###   @9='UNI'
###   @10=1768075554
###   @11=1776266264
###   @12=3
###   @13='7898960399165'
###   @14=1
# at 56014
#260415  9:17:44 server id 1  end_log_pos 56105 CRC32 0xc03b91df 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 56105
#260415  9:17:44 server id 1  end_log_pos 56265 CRC32 0xdd6217e3 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6918
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF 22 GÁS NF. 57.740'
###   @4=2112.00
###   @5='2026:04:15'
###   @6='2026:04:20'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776266264
###   @12=1776266264
###   @13=5
###   @14=415
###   @15=1
###   @16=1
# at 56265
#260415  9:17:44 server id 1  end_log_pos 56296 CRC32 0x52bc163e 	Xid = 11810
COMMIT/*!*/;
# at 56296
#260415 10:21:37 server id 1  end_log_pos 56375 CRC32 0xfa27bf1c 	Anonymous_GTID	last_committed=64	sequence_number=65	rbr_only=yes	original_committed_timestamp=1776259297130462	immediate_commit_timestamp=1776259297130462	transaction_length=4086
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259297130462 (2026-04-15 10:21:37.130462 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259297130462 (2026-04-15 10:21:37.130462 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259297130462*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 56375
#260415 10:21:37 server id 1  end_log_pos 56463 CRC32 0xa3cba5ca 	Query	thread_id=415	exec_time=0	error_code=0
SET TIMESTAMP=1776259297/*!*/;
BEGIN
/*!*/;
# at 56463
#260415 10:21:37 server id 1  end_log_pos 56548 CRC32 0x358d0a21 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 56548
#260415 10:21:37 server id 1  end_log_pos 56672 CRC32 0xf6ddd26f 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=416
###   @2=566
###   @3=720.00
###   @4=1776270097
###   @5=1776270097
###   @6=7
###   @7='PATROCÍNIO DO MARIGÁS'
###   @8=NULL
###   @9='2026:04:15'
###   @10='2026:05:15'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=3
# at 56672
#260415 10:21:37 server id 1  end_log_pos 56750 CRC32 0x5fbf97ab 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 56750
#260415 10:21:37 server id 1  end_log_pos 56832 CRC32 0x95d57159 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=416
###   @2=416
###   @3=4
###   @4=1
###   @5=720.00
###   @6=720.00
###   @7=1776270097
###   @8=1776270097
# at 56832
#260415 10:21:37 server id 1  end_log_pos 56906 CRC32 0xbfb92434 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 56906
#260415 10:21:37 server id 1  end_log_pos 56991 CRC32 0xf1128110 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1623
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776270097
###   @7=1776270097
###   @8=1776270097
# at 56991
#260415 10:21:37 server id 1  end_log_pos 57082 CRC32 0x9afaa4d2 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 57082
#260415 10:21:37 server id 1  end_log_pos 57264 CRC32 0x665db7ed 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9898
###   @9='UNI'
###   @10=1768151301
###   @11=1776178572
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9899
###   @9='UNI'
###   @10=1768151301
###   @11=1776270097
###   @12=5
###   @13='999'
###   @14=NULL
# at 57264
#260415 10:21:37 server id 1  end_log_pos 57355 CRC32 0x8176e910 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 57355
#260415 10:21:37 server id 1  end_log_pos 57521 CRC32 0x568bd836 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6919
###   @2=566
###   @3='Compra de produtos - Parcela 1/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=1
###   @16=1
# at 57521
#260415 10:21:37 server id 1  end_log_pos 57612 CRC32 0xafc6195c 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 57612
#260415 10:21:37 server id 1  end_log_pos 57778 CRC32 0x0a99f258 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6920
###   @2=566
###   @3='Compra de produtos - Parcela 2/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=2
###   @16=1
# at 57778
#260415 10:21:37 server id 1  end_log_pos 57869 CRC32 0x8bac1a54 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 57869
#260415 10:21:37 server id 1  end_log_pos 58035 CRC32 0x2d6cc0ab 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6921
###   @2=566
###   @3='Compra de produtos - Parcela 3/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=3
###   @16=1
# at 58035
#260415 10:21:37 server id 1  end_log_pos 58126 CRC32 0x8ec163f6 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 58126
#260415 10:21:37 server id 1  end_log_pos 58292 CRC32 0x511c1bcd 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6922
###   @2=566
###   @3='Compra de produtos - Parcela 4/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=4
###   @16=1
# at 58292
#260415 10:21:37 server id 1  end_log_pos 58383 CRC32 0xc3781c44 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 58383
#260415 10:21:37 server id 1  end_log_pos 58549 CRC32 0xc9952f50 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6923
###   @2=566
###   @3='Compra de produtos - Parcela 5/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=5
###   @16=1
# at 58549
#260415 10:21:37 server id 1  end_log_pos 58640 CRC32 0x1505d86c 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 58640
#260415 10:21:37 server id 1  end_log_pos 58806 CRC32 0x7e4d38a0 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6924
###   @2=566
###   @3='Compra de produtos - Parcela 6/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=6
###   @16=1
# at 58806
#260415 10:21:37 server id 1  end_log_pos 58897 CRC32 0x316fdb64 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 58897
#260415 10:21:37 server id 1  end_log_pos 59063 CRC32 0xa385f904 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6925
###   @2=566
###   @3='Compra de produtos - Parcela 7/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=7
###   @16=1
# at 59063
#260415 10:21:37 server id 1  end_log_pos 59154 CRC32 0x3402a2c6 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 59154
#260415 10:21:37 server id 1  end_log_pos 59320 CRC32 0x358cd41c 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6926
###   @2=566
###   @3='Compra de produtos - Parcela 8/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=8
###   @16=1
# at 59320
#260415 10:21:37 server id 1  end_log_pos 59411 CRC32 0xaa1d2400 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 59411
#260415 10:21:37 server id 1  end_log_pos 59577 CRC32 0x9413d2dc 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6927
###   @2=566
###   @3='Compra de produtos - Parcela 9/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=9
###   @16=1
# at 59577
#260415 10:21:37 server id 1  end_log_pos 59668 CRC32 0x84add44c 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 59668
#260415 10:21:37 server id 1  end_log_pos 59835 CRC32 0x1f10d0d6 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6928
###   @2=566
###   @3='Compra de produtos - Parcela 10/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=10
###   @16=1
# at 59835
#260415 10:21:37 server id 1  end_log_pos 59926 CRC32 0x5266f2e8 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 59926
#260415 10:21:37 server id 1  end_log_pos 60093 CRC32 0x6d90e221 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6929
###   @2=566
###   @3='Compra de produtos - Parcela 11/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2027:03:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=11
###   @16=1
# at 60093
#260415 10:21:37 server id 1  end_log_pos 60184 CRC32 0xcc22f023 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 60184
#260415 10:21:37 server id 1  end_log_pos 60351 CRC32 0xb10159c4 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6930
###   @2=566
###   @3='Compra de produtos - Parcela 12/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2027:04:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=12
###   @16=1
# at 60351
#260415 10:21:37 server id 1  end_log_pos 60382 CRC32 0xcf3e388f 	Xid = 12331
COMMIT/*!*/;
# at 60382
#260415 10:21:45 server id 1  end_log_pos 60461 CRC32 0xdc3ab811 	Anonymous_GTID	last_committed=65	sequence_number=66	rbr_only=yes	original_committed_timestamp=1776259305303231	immediate_commit_timestamp=1776259305303231	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259305303231 (2026-04-15 10:21:45.303231 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259305303231 (2026-04-15 10:21:45.303231 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259305303231*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 60461
#260415 10:21:45 server id 1  end_log_pos 60556 CRC32 0xbf866355 	Query	thread_id=417	exec_time=0	error_code=0
SET TIMESTAMP=1776259305/*!*/;
BEGIN
/*!*/;
# at 60556
#260415 10:21:45 server id 1  end_log_pos 60647 CRC32 0x06ebf59e 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 60647
#260415 10:21:45 server id 1  end_log_pos 62149 CRC32 0x99fb494d 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776266198
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270105
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776266198
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270105
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776266198
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270105
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 62149
#260415 10:21:45 server id 1  end_log_pos 62180 CRC32 0xde432f40 	Xid = 12410
COMMIT/*!*/;
# at 62180
#260415 10:21:45 server id 1  end_log_pos 62259 CRC32 0xed5a87e7 	Anonymous_GTID	last_committed=66	sequence_number=67	rbr_only=yes	original_committed_timestamp=1776259305306469	immediate_commit_timestamp=1776259305306469	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259305306469 (2026-04-15 10:21:45.306469 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259305306469 (2026-04-15 10:21:45.306469 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259305306469*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 62259
#260415 10:21:45 server id 1  end_log_pos 62354 CRC32 0xbcf55a06 	Query	thread_id=417	exec_time=0	error_code=0
SET TIMESTAMP=1776259305/*!*/;
BEGIN
/*!*/;
# at 62354
#260415 10:21:45 server id 1  end_log_pos 62445 CRC32 0x41d2b181 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 62445
#260415 10:21:45 server id 1  end_log_pos 62939 CRC32 0x2d478d40 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776266198
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 62939
#260415 10:21:45 server id 1  end_log_pos 62970 CRC32 0x04dc49ed 	Xid = 12413
COMMIT/*!*/;
# at 62970
#260415 10:21:51 server id 1  end_log_pos 63049 CRC32 0x03dbb357 	Anonymous_GTID	last_committed=67	sequence_number=68	rbr_only=yes	original_committed_timestamp=1776259311664326	immediate_commit_timestamp=1776259311664326	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259311664326 (2026-04-15 10:21:51.664326 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259311664326 (2026-04-15 10:21:51.664326 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259311664326*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 63049
#260415 10:21:51 server id 1  end_log_pos 63144 CRC32 0x1daf8ad9 	Query	thread_id=418	exec_time=0	error_code=0
SET TIMESTAMP=1776259311/*!*/;
BEGIN
/*!*/;
# at 63144
#260415 10:21:51 server id 1  end_log_pos 63235 CRC32 0x3555e551 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 63235
#260415 10:21:51 server id 1  end_log_pos 64737 CRC32 0xb6d71ac6 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270105
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270111
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270105
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270111
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270105
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270111
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 64737
#260415 10:21:51 server id 1  end_log_pos 64768 CRC32 0xabb72d00 	Xid = 14495
COMMIT/*!*/;
# at 64768
#260415 10:21:51 server id 1  end_log_pos 64847 CRC32 0x0985eec3 	Anonymous_GTID	last_committed=68	sequence_number=69	rbr_only=yes	original_committed_timestamp=1776259311667373	immediate_commit_timestamp=1776259311667373	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259311667373 (2026-04-15 10:21:51.667373 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259311667373 (2026-04-15 10:21:51.667373 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259311667373*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 64847
#260415 10:21:51 server id 1  end_log_pos 64942 CRC32 0x5d79f43e 	Query	thread_id=418	exec_time=0	error_code=0
SET TIMESTAMP=1776259311/*!*/;
BEGIN
/*!*/;
# at 64942
#260415 10:21:51 server id 1  end_log_pos 65033 CRC32 0x536a9700 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 65033
#260415 10:21:51 server id 1  end_log_pos 65527 CRC32 0x26036d1b 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270105
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 65527
#260415 10:21:51 server id 1  end_log_pos 65558 CRC32 0xed1869f4 	Xid = 14498
COMMIT/*!*/;
# at 65558
#260415 10:22:18 server id 1  end_log_pos 65637 CRC32 0x8aeddd07 	Anonymous_GTID	last_committed=69	sequence_number=70	rbr_only=yes	original_committed_timestamp=1776259338307643	immediate_commit_timestamp=1776259338307643	transaction_length=399
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259338307643 (2026-04-15 10:22:18.307643 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259338307643 (2026-04-15 10:22:18.307643 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259338307643*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 65637
#260415 10:22:18 server id 1  end_log_pos 65717 CRC32 0xe4136afc 	Query	thread_id=420	exec_time=0	error_code=0
SET TIMESTAMP=1776259338/*!*/;
BEGIN
/*!*/;
# at 65717
#260415 10:22:18 server id 1  end_log_pos 65802 CRC32 0xbae62577 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 65802
#260415 10:22:18 server id 1  end_log_pos 65926 CRC32 0x32cc15c9 	Delete_rows: table id 83 flags: STMT_END_F
### DELETE FROM `marigas`.`compras`
### WHERE
###   @1=416
###   @2=566
###   @3=720.00
###   @4=1776270097
###   @5=1776270097
###   @6=7
###   @7='PATROCÍNIO DO MARIGÁS'
###   @8=NULL
###   @9='2026:04:15'
###   @10='2026:05:15'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=3
# at 65926
#260415 10:22:18 server id 1  end_log_pos 65957 CRC32 0x0a19a09a 	Xid = 14597
COMMIT/*!*/;
# at 65957
#260415 10:23:44 server id 1  end_log_pos 66036 CRC32 0x64dbf03f 	Anonymous_GTID	last_committed=70	sequence_number=71	rbr_only=yes	original_committed_timestamp=1776259424394373	immediate_commit_timestamp=1776259424394373	transaction_length=1209
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259424394373 (2026-04-15 10:23:44.394373 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259424394373 (2026-04-15 10:23:44.394373 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259424394373*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 66036
#260415 10:23:44 server id 1  end_log_pos 66124 CRC32 0xa3c73c69 	Query	thread_id=425	exec_time=0	error_code=0
SET TIMESTAMP=1776259424/*!*/;
BEGIN
/*!*/;
# at 66124
#260415 10:23:44 server id 1  end_log_pos 66209 CRC32 0x36fdc20e 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 66209
#260415 10:23:44 server id 1  end_log_pos 66332 CRC32 0x83c93430 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=417
###   @2=566
###   @3=60.00
###   @4=1776270224
###   @5=1776270224
###   @6=1
###   @7='PATROCÍNIO - MARIGÁS'
###   @8=NULL
###   @9='2026:04:15'
###   @10='2026:04:16'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=2
# at 66332
#260415 10:23:44 server id 1  end_log_pos 66410 CRC32 0xcd320112 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 66410
#260415 10:23:44 server id 1  end_log_pos 66492 CRC32 0xa4d87cab 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=417
###   @2=417
###   @3=4
###   @4=1
###   @5=60.00
###   @6=60.00
###   @7=1776270224
###   @8=1776270224
# at 66492
#260415 10:23:44 server id 1  end_log_pos 66566 CRC32 0x8c848693 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 66566
#260415 10:23:44 server id 1  end_log_pos 66651 CRC32 0x55f12aef 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1624
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776270224
###   @7=1776270224
###   @8=1776270224
# at 66651
#260415 10:23:44 server id 1  end_log_pos 66742 CRC32 0x053b20d3 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 66742
#260415 10:23:44 server id 1  end_log_pos 66924 CRC32 0x58e39b11 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9899
###   @9='UNI'
###   @10=1768151301
###   @11=1776270097
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9900
###   @9='UNI'
###   @10=1768151301
###   @11=1776270224
###   @12=5
###   @13='999'
###   @14=NULL
# at 66924
#260415 10:23:44 server id 1  end_log_pos 67009 CRC32 0x20ee3e97 	Table_map: `marigas`.`caixa_banco` mapped to number 95
# has_generated_invisible_primary_key=0
# at 67009
#260415 10:23:44 server id 1  end_log_pos 67135 CRC32 0xedc523e4 	Write_rows: table id 95 flags: STMT_END_F
### INSERT INTO `marigas`.`caixa_banco`
### SET
###   @1=816
###   @2='2026:04:15'
###   @3=2
###   @4=60.00
###   @5='pix'
###   @6='compra'
###   @7='Compra via PIX - NF PATROCÍNIO - MARIGÁS'
###   @8=417
###   @9=1776270224
###   @10=1776270224
# at 67135
#260415 10:23:44 server id 1  end_log_pos 67166 CRC32 0x81f22103 	Xid = 14673
COMMIT/*!*/;
# at 67166
#260415 10:28:28 server id 1  end_log_pos 67245 CRC32 0xd9497932 	Anonymous_GTID	last_committed=71	sequence_number=72	rbr_only=yes	original_committed_timestamp=1776259708153060	immediate_commit_timestamp=1776259708153060	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259708153060 (2026-04-15 10:28:28.153060 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259708153060 (2026-04-15 10:28:28.153060 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259708153060*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 67245
#260415 10:28:28 server id 1  end_log_pos 67340 CRC32 0x15daccdd 	Query	thread_id=431	exec_time=0	error_code=0
SET TIMESTAMP=1776259708/*!*/;
BEGIN
/*!*/;
# at 67340
#260415 10:28:28 server id 1  end_log_pos 67431 CRC32 0x4cdf5b5e 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 67431
#260415 10:28:28 server id 1  end_log_pos 68933 CRC32 0x9853e8fd 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270111
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270508
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270111
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270508
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270111
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270508
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 68933
#260415 10:28:28 server id 1  end_log_pos 68964 CRC32 0x0124794a 	Xid = 14803
COMMIT/*!*/;
# at 68964
#260415 10:28:28 server id 1  end_log_pos 69043 CRC32 0xa1ffc9e9 	Anonymous_GTID	last_committed=72	sequence_number=73	rbr_only=yes	original_committed_timestamp=1776259708155666	immediate_commit_timestamp=1776259708155666	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259708155666 (2026-04-15 10:28:28.155666 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259708155666 (2026-04-15 10:28:28.155666 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259708155666*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 69043
#260415 10:28:28 server id 1  end_log_pos 69138 CRC32 0x57b7f47a 	Query	thread_id=431	exec_time=0	error_code=0
SET TIMESTAMP=1776259708/*!*/;
BEGIN
/*!*/;
# at 69138
#260415 10:28:28 server id 1  end_log_pos 69229 CRC32 0x2ae0290f 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 69229
#260415 10:28:28 server id 1  end_log_pos 69723 CRC32 0x3635b8f5 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270111
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 69723
#260415 10:28:28 server id 1  end_log_pos 69754 CRC32 0x17c6d866 	Xid = 14806
COMMIT/*!*/;
# at 69754
#260415 10:28:32 server id 1  end_log_pos 69833 CRC32 0x9f1934d2 	Anonymous_GTID	last_committed=73	sequence_number=74	rbr_only=yes	original_committed_timestamp=1776259712432600	immediate_commit_timestamp=1776259712432600	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259712432600 (2026-04-15 10:28:32.432600 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259712432600 (2026-04-15 10:28:32.432600 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259712432600*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 69833
#260415 10:28:32 server id 1  end_log_pos 69928 CRC32 0x250f67f8 	Query	thread_id=432	exec_time=0	error_code=0
SET TIMESTAMP=1776259712/*!*/;
BEGIN
/*!*/;
# at 69928
#260415 10:28:32 server id 1  end_log_pos 70019 CRC32 0xe155ad03 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 70019
#260415 10:28:32 server id 1  end_log_pos 71521 CRC32 0x287069e8 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270508
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270512
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270508
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270512
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270508
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270512
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 71521
#260415 10:28:32 server id 1  end_log_pos 71552 CRC32 0x9f2e0d64 	Xid = 16888
COMMIT/*!*/;
# at 71552
#260415 10:28:32 server id 1  end_log_pos 71631 CRC32 0xf8abd0e8 	Anonymous_GTID	last_committed=74	sequence_number=75	rbr_only=yes	original_committed_timestamp=1776259712435112	immediate_commit_timestamp=1776259712435112	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259712435112 (2026-04-15 10:28:32.435112 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259712435112 (2026-04-15 10:28:32.435112 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259712435112*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 71631
#260415 10:28:32 server id 1  end_log_pos 71726 CRC32 0x3d76a16a 	Query	thread_id=432	exec_time=0	error_code=0
SET TIMESTAMP=1776259712/*!*/;
BEGIN
/*!*/;
# at 71726
#260415 10:28:32 server id 1  end_log_pos 71817 CRC32 0x876adf52 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 71817
#260415 10:28:32 server id 1  end_log_pos 72311 CRC32 0xb0981bac 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270508
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 72311
#260415 10:28:32 server id 1  end_log_pos 72342 CRC32 0xc8fd1d23 	Xid = 16891
COMMIT/*!*/;
# at 72342
#260415 10:32:34 server id 1  end_log_pos 72421 CRC32 0xc3148420 	Anonymous_GTID	last_committed=75	sequence_number=76	rbr_only=yes	original_committed_timestamp=1776259954728619	immediate_commit_timestamp=1776259954728619	transaction_length=3471
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259954728619 (2026-04-15 10:32:34.728619 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259954728619 (2026-04-15 10:32:34.728619 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259954728619*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 72421
#260415 10:32:34 server id 1  end_log_pos 72509 CRC32 0xe86c3b56 	Query	thread_id=434	exec_time=0	error_code=0
SET TIMESTAMP=1776259954/*!*/;
BEGIN
/*!*/;
# at 72509
#260415 10:32:34 server id 1  end_log_pos 72594 CRC32 0x6151eeec 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 72594
#260415 10:32:34 server id 1  end_log_pos 72709 CRC32 0xd5f6be9e 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=418
###   @2=424
###   @3=700.00
###   @4=1776270754
###   @5=1776270754
###   @6=7
###   @7='VIVO TELEFONIA'
###   @8=NULL
###   @9='2026:04:15'
###   @10='2026:05:15'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=3
# at 72709
#260415 10:32:34 server id 1  end_log_pos 72787 CRC32 0x8ce53570 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 72787
#260415 10:32:34 server id 1  end_log_pos 72869 CRC32 0x37ce1ddc 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=418
###   @2=418
###   @3=4
###   @4=1
###   @5=700.00
###   @6=700.00
###   @7=1776270754
###   @8=1776270754
# at 72869
#260415 10:32:34 server id 1  end_log_pos 72943 CRC32 0x36b8b5ca 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 72943
#260415 10:32:34 server id 1  end_log_pos 73028 CRC32 0xd2c8d820 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1625
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776270754
###   @7=1776270754
###   @8=1776270754
# at 73028
#260415 10:32:34 server id 1  end_log_pos 73119 CRC32 0xd9eb3644 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 73119
#260415 10:32:34 server id 1  end_log_pos 73301 CRC32 0xd6054f26 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9900
###   @9='UNI'
###   @10=1768151301
###   @11=1776270224
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9901
###   @9='UNI'
###   @10=1768151301
###   @11=1776270754
###   @12=5
###   @13='999'
###   @14=NULL
# at 73301
#260415 10:32:34 server id 1  end_log_pos 73392 CRC32 0x66c87ce4 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 73392
#260415 10:32:34 server id 1  end_log_pos 73549 CRC32 0x336e2cec 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6931
###   @2=424
###   @3='Compra de produtos - Parcela 1/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=1
###   @16=1
# at 73549
#260415 10:32:34 server id 1  end_log_pos 73640 CRC32 0x69c9148e 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 73640
#260415 10:32:34 server id 1  end_log_pos 73797 CRC32 0xae70aba0 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6932
###   @2=424
###   @3='Compra de produtos - Parcela 2/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=2
###   @16=1
# at 73797
#260415 10:32:34 server id 1  end_log_pos 73888 CRC32 0xc3677d34 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 73888
#260415 10:32:34 server id 1  end_log_pos 74045 CRC32 0x83d50d6c 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6933
###   @2=424
###   @3='Compra de produtos - Parcela 3/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=3
###   @16=1
# at 74045
#260415 10:32:34 server id 1  end_log_pos 74136 CRC32 0x49fb5c6f 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 74136
#260415 10:32:34 server id 1  end_log_pos 74293 CRC32 0xe54e8bae 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6934
###   @2=424
###   @3='Compra de produtos - Parcela 4/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=4
###   @16=1
# at 74293
#260415 10:32:34 server id 1  end_log_pos 74384 CRC32 0xdd65ade0 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 74384
#260415 10:32:34 server id 1  end_log_pos 74541 CRC32 0xc661579a 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6935
###   @2=424
###   @3='Compra de produtos - Parcela 5/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=5
###   @16=1
# at 74541
#260415 10:32:34 server id 1  end_log_pos 74632 CRC32 0xd264c58a 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 74632
#260415 10:32:34 server id 1  end_log_pos 74789 CRC32 0xdbcf0f3b 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6936
###   @2=424
###   @3='Compra de produtos - Parcela 6/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=6
###   @16=1
# at 74789
#260415 10:32:34 server id 1  end_log_pos 74880 CRC32 0x2f2948bf 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 74880
#260415 10:32:34 server id 1  end_log_pos 75037 CRC32 0x7bf317b5 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6937
###   @2=424
###   @3='Compra de produtos - Parcela 7/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=7
###   @16=1
# at 75037
#260415 10:32:34 server id 1  end_log_pos 75128 CRC32 0x0e18d3c0 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 75128
#260415 10:32:34 server id 1  end_log_pos 75285 CRC32 0xdab5be84 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6938
###   @2=424
###   @3='Compra de produtos - Parcela 8/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=8
###   @16=1
# at 75285
#260415 10:32:34 server id 1  end_log_pos 75376 CRC32 0x9a86224f 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 75376
#260415 10:32:34 server id 1  end_log_pos 75533 CRC32 0xe0fd78bf 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6939
###   @2=424
###   @3='Compra de produtos - Parcela 9/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=9
###   @16=1
# at 75533
#260415 10:32:34 server id 1  end_log_pos 75624 CRC32 0x95874a25 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 75624
#260415 10:32:34 server id 1  end_log_pos 75782 CRC32 0xc6475a8b 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6940
###   @2=424
###   @3='Compra de produtos - Parcela 10/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=10
###   @16=1
# at 75782
#260415 10:32:34 server id 1  end_log_pos 75813 CRC32 0xacae3f25 	Xid = 16943
COMMIT/*!*/;
# at 75813
#260415 10:32:44 server id 1  end_log_pos 75892 CRC32 0xd8bdaa75 	Anonymous_GTID	last_committed=76	sequence_number=77	rbr_only=yes	original_committed_timestamp=1776259964152883	immediate_commit_timestamp=1776259964152883	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259964152883 (2026-04-15 10:32:44.152883 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259964152883 (2026-04-15 10:32:44.152883 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259964152883*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 75892
#260415 10:32:44 server id 1  end_log_pos 75987 CRC32 0x2e011117 	Query	thread_id=436	exec_time=0	error_code=0
SET TIMESTAMP=1776259964/*!*/;
BEGIN
/*!*/;
# at 75987
#260415 10:32:44 server id 1  end_log_pos 76078 CRC32 0xc031dd51 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 76078
#260415 10:32:44 server id 1  end_log_pos 77580 CRC32 0x02943c1a 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270512
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270764
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270512
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270764
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270512
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270764
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 77580
#260415 10:32:44 server id 1  end_log_pos 77611 CRC32 0x3b7e1d6f 	Xid = 17016
COMMIT/*!*/;
# at 77611
#260415 10:32:44 server id 1  end_log_pos 77690 CRC32 0xda18cbed 	Anonymous_GTID	last_committed=77	sequence_number=78	rbr_only=yes	original_committed_timestamp=1776259964155746	immediate_commit_timestamp=1776259964155746	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776259964155746 (2026-04-15 10:32:44.155746 Hora oficial do Brasil)
# immediate_commit_timestamp=1776259964155746 (2026-04-15 10:32:44.155746 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776259964155746*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 77690
#260415 10:32:44 server id 1  end_log_pos 77785 CRC32 0xa6f504b5 	Query	thread_id=436	exec_time=0	error_code=0
SET TIMESTAMP=1776259964/*!*/;
BEGIN
/*!*/;
# at 77785
#260415 10:32:44 server id 1  end_log_pos 77876 CRC32 0x75447c11 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 77876
#260415 10:32:44 server id 1  end_log_pos 78370 CRC32 0x25fe21a1 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270512
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 78370
#260415 10:32:44 server id 1  end_log_pos 78401 CRC32 0x1830899a 	Xid = 17019
COMMIT/*!*/;
# at 78401
#260415 10:33:45 server id 1  end_log_pos 78480 CRC32 0x7db5b71f 	Anonymous_GTID	last_committed=78	sequence_number=79	rbr_only=yes	original_committed_timestamp=1776260025879866	immediate_commit_timestamp=1776260025879866	transaction_length=1237
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260025879866 (2026-04-15 10:33:45.879866 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260025879866 (2026-04-15 10:33:45.879866 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260025879866*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 78480
#260415 10:33:45 server id 1  end_log_pos 78568 CRC32 0xb4e57ca7 	Query	thread_id=438	exec_time=0	error_code=0
SET TIMESTAMP=1776260025/*!*/;
BEGIN
/*!*/;
# at 78568
#260415 10:33:45 server id 1  end_log_pos 78653 CRC32 0xad5879db 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 78653
#260415 10:33:45 server id 1  end_log_pos 78768 CRC32 0x4e56d180 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=419
###   @2=424
###   @3=70.00
###   @4=1776270825
###   @5=1776270825
###   @6=4
###   @7='VIVO TELEFONIA'
###   @8=NULL
###   @9='2026:04:15'
###   @10='2026:04:25'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=3
# at 78768
#260415 10:33:45 server id 1  end_log_pos 78846 CRC32 0x75151c37 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 78846
#260415 10:33:45 server id 1  end_log_pos 78928 CRC32 0xecc2acf7 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=419
###   @2=419
###   @3=4
###   @4=1
###   @5=70.00
###   @6=70.00
###   @7=1776270825
###   @8=1776270825
# at 78928
#260415 10:33:45 server id 1  end_log_pos 79002 CRC32 0xd8ff40a5 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 79002
#260415 10:33:45 server id 1  end_log_pos 79087 CRC32 0x0474d668 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1626
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776270825
###   @7=1776270825
###   @8=1776270825
# at 79087
#260415 10:33:45 server id 1  end_log_pos 79178 CRC32 0xfefaf77e 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 79178
#260415 10:33:45 server id 1  end_log_pos 79360 CRC32 0xc82dced9 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9901
###   @9='UNI'
###   @10=1768151301
###   @11=1776270754
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9902
###   @9='UNI'
###   @10=1768151301
###   @11=1776270825
###   @12=5
###   @13='999'
###   @14=NULL
# at 79360
#260415 10:33:45 server id 1  end_log_pos 79451 CRC32 0x02ba8d92 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 79451
#260415 10:33:45 server id 1  end_log_pos 79607 CRC32 0xedbe2383 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6941
###   @2=424
###   @3='Compra de produtos - Parcela 1/1 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:04:25'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270825
###   @12=1776270825
###   @13=10
###   @14=419
###   @15=1
###   @16=1
# at 79607
#260415 10:33:45 server id 1  end_log_pos 79638 CRC32 0x5a8639d8 	Xid = 17119
COMMIT/*!*/;
# at 79638
#260415 10:33:51 server id 1  end_log_pos 79717 CRC32 0xc39281cc 	Anonymous_GTID	last_committed=79	sequence_number=80	rbr_only=yes	original_committed_timestamp=1776260031577007	immediate_commit_timestamp=1776260031577007	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260031577007 (2026-04-15 10:33:51.577007 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260031577007 (2026-04-15 10:33:51.577007 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260031577007*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 79717
#260415 10:33:51 server id 1  end_log_pos 79812 CRC32 0x51baf0a6 	Query	thread_id=440	exec_time=0	error_code=0
SET TIMESTAMP=1776260031/*!*/;
BEGIN
/*!*/;
# at 79812
#260415 10:33:51 server id 1  end_log_pos 79903 CRC32 0x2d5c2e76 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 79903
#260415 10:33:51 server id 1  end_log_pos 81405 CRC32 0x0648a190 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270764
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270831
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270764
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270831
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270764
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270831
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 81405
#260415 10:33:51 server id 1  end_log_pos 81436 CRC32 0x5132ceb9 	Xid = 17165
COMMIT/*!*/;
# at 81436
#260415 10:33:51 server id 1  end_log_pos 81515 CRC32 0x34ef9d5a 	Anonymous_GTID	last_committed=80	sequence_number=81	rbr_only=yes	original_committed_timestamp=1776260031580186	immediate_commit_timestamp=1776260031580186	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260031580186 (2026-04-15 10:33:51.580186 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260031580186 (2026-04-15 10:33:51.580186 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260031580186*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 81515
#260415 10:33:51 server id 1  end_log_pos 81610 CRC32 0xc91f9e18 	Query	thread_id=440	exec_time=0	error_code=0
SET TIMESTAMP=1776260031/*!*/;
BEGIN
/*!*/;
# at 81610
#260415 10:33:51 server id 1  end_log_pos 81701 CRC32 0xef14093d 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 81701
#260415 10:33:51 server id 1  end_log_pos 82195 CRC32 0x2546936f 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270764
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 82195
#260415 10:33:51 server id 1  end_log_pos 82226 CRC32 0x2df76eaa 	Xid = 17168
COMMIT/*!*/;
# at 82226
#260415 10:35:09 server id 1  end_log_pos 82305 CRC32 0xac810135 	Anonymous_GTID	last_committed=81	sequence_number=82	rbr_only=yes	original_committed_timestamp=1776260109928619	immediate_commit_timestamp=1776260109928619	transaction_length=1798
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260109928619 (2026-04-15 10:35:09.928619 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260109928619 (2026-04-15 10:35:09.928619 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260109928619*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 82305
#260415 10:35:09 server id 1  end_log_pos 82400 CRC32 0x5f5a849a 	Query	thread_id=443	exec_time=0	error_code=0
SET TIMESTAMP=1776260109/*!*/;
BEGIN
/*!*/;
# at 82400
#260415 10:35:09 server id 1  end_log_pos 82491 CRC32 0xcf5cb385 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 82491
#260415 10:35:09 server id 1  end_log_pos 83993 CRC32 0x5fcc9668 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270831
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270909
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270831
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270909
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270831
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270909
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 83993
#260415 10:35:09 server id 1  end_log_pos 84024 CRC32 0x8661eb1d 	Xid = 17276
COMMIT/*!*/;
# at 84024
#260415 10:35:09 server id 1  end_log_pos 84103 CRC32 0xf432acf5 	Anonymous_GTID	last_committed=82	sequence_number=83	rbr_only=yes	original_committed_timestamp=1776260109931506	immediate_commit_timestamp=1776260109931506	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260109931506 (2026-04-15 10:35:09.931506 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260109931506 (2026-04-15 10:35:09.931506 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260109931506*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 84103
#260415 10:35:09 server id 1  end_log_pos 84198 CRC32 0x47234208 	Query	thread_id=443	exec_time=0	error_code=0
SET TIMESTAMP=1776260109/*!*/;
BEGIN
/*!*/;
# at 84198
#260415 10:35:09 server id 1  end_log_pos 84289 CRC32 0x672a8523 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 84289
#260415 10:35:09 server id 1  end_log_pos 84783 CRC32 0x4ddac497 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270831
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 84783
#260415 10:35:09 server id 1  end_log_pos 84814 CRC32 0xa78978c3 	Xid = 17279
COMMIT/*!*/;
# at 84814
#260415 10:35:35 server id 1  end_log_pos 84893 CRC32 0xa2a16d5f 	Anonymous_GTID	last_committed=83	sequence_number=84	rbr_only=yes	original_committed_timestamp=1776260135507823	immediate_commit_timestamp=1776260135507823	transaction_length=582
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260135507823 (2026-04-15 10:35:35.507823 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260135507823 (2026-04-15 10:35:35.507823 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260135507823*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 84893
#260415 10:35:35 server id 1  end_log_pos 84988 CRC32 0xa54e02d4 	Query	thread_id=445	exec_time=0	error_code=0
SET TIMESTAMP=1776260135/*!*/;
BEGIN
/*!*/;
# at 84988
#260415 10:35:35 server id 1  end_log_pos 85079 CRC32 0xe2cf8625 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 85079
#260415 10:35:35 server id 1  end_log_pos 85365 CRC32 0x3b9cafb5 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270909
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270935
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
# at 85365
#260415 10:35:35 server id 1  end_log_pos 85396 CRC32 0x9fa32c2e 	Xid = 17346
COMMIT/*!*/;
# at 85396
#260415 10:35:35 server id 1  end_log_pos 85475 CRC32 0xc747dee0 	Anonymous_GTID	last_committed=84	sequence_number=85	rbr_only=yes	original_committed_timestamp=1776260135683429	immediate_commit_timestamp=1776260135683429	transaction_length=1550
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260135683429 (2026-04-15 10:35:35.683429 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260135683429 (2026-04-15 10:35:35.683429 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260135683429*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 85475
#260415 10:35:35 server id 1  end_log_pos 85570 CRC32 0xc8c95a0f 	Query	thread_id=446	exec_time=0	error_code=0
SET TIMESTAMP=1776260135/*!*/;
BEGIN
/*!*/;
# at 85570
#260415 10:35:35 server id 1  end_log_pos 85661 CRC32 0x3fde5577 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 85661
#260415 10:35:35 server id 1  end_log_pos 86915 CRC32 0xb9ae14bc 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270909
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270935
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270909
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270935
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 86915
#260415 10:35:35 server id 1  end_log_pos 86946 CRC32 0x97dc9b74 	Xid = 17356
COMMIT/*!*/;
# at 86946
#260415 10:35:35 server id 1  end_log_pos 87025 CRC32 0xe112be61 	Anonymous_GTID	last_committed=85	sequence_number=86	rbr_only=yes	original_committed_timestamp=1776260135686733	immediate_commit_timestamp=1776260135686733	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260135686733 (2026-04-15 10:35:35.686733 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260135686733 (2026-04-15 10:35:35.686733 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260135686733*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 87025
#260415 10:35:35 server id 1  end_log_pos 87120 CRC32 0x7bb8b096 	Query	thread_id=446	exec_time=0	error_code=0
SET TIMESTAMP=1776260135/*!*/;
BEGIN
/*!*/;
# at 87120
#260415 10:35:35 server id 1  end_log_pos 87211 CRC32 0xb075c567 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 87211
#260415 10:35:35 server id 1  end_log_pos 87705 CRC32 0x0c9349c7 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270909
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 87705
#260415 10:35:35 server id 1  end_log_pos 87736 CRC32 0xb0f9c973 	Xid = 17359
COMMIT/*!*/;
# at 87736
#260415 10:36:30 server id 1  end_log_pos 87815 CRC32 0x602c3aa7 	Anonymous_GTID	last_committed=86	sequence_number=87	rbr_only=yes	original_committed_timestamp=1776260190076911	immediate_commit_timestamp=1776260190076911	transaction_length=3394
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260190076911 (2026-04-15 10:36:30.076911 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260190076911 (2026-04-15 10:36:30.076911 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260190076911*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 87815
#260415 10:36:30 server id 1  end_log_pos 87903 CRC32 0xccfe284d 	Query	thread_id=448	exec_time=0	error_code=0
SET TIMESTAMP=1776260190/*!*/;
BEGIN
/*!*/;
# at 87903
#260415 10:36:30 server id 1  end_log_pos 87988 CRC32 0xa09805ee 	Table_map: `marigas`.`compras` mapped to number 83
# has_generated_invisible_primary_key=0
# at 87988
#260415 10:36:30 server id 1  end_log_pos 88096 CRC32 0x63c5df9d 	Write_rows: table id 83 flags: STMT_END_F
### INSERT INTO `marigas`.`compras`
### SET
###   @1=420
###   @2=565
###   @3=30.00
###   @4=1776270990
###   @5=1776270990
###   @6=7
###   @7='SIMPLES'
###   @8=NULL
###   @9='2026:04:15'
###   @10='2026:05:15'
###   @11=NULL
###   @12='pendente'
###   @13=NULL
###   @14=NULL
###   @15=3
# at 88096
#260415 10:36:30 server id 1  end_log_pos 88174 CRC32 0x2f8a4d6d 	Table_map: `marigas`.`itens_de_compras` mapped to number 88
# has_generated_invisible_primary_key=0
# at 88174
#260415 10:36:30 server id 1  end_log_pos 88256 CRC32 0x4ff94cb6 	Write_rows: table id 88 flags: STMT_END_F
### INSERT INTO `marigas`.`itens_de_compras`
### SET
###   @1=420
###   @2=420
###   @3=4
###   @4=1
###   @5=30.00
###   @6=30.00
###   @7=1776270990
###   @8=1776270990
# at 88256
#260415 10:36:30 server id 1  end_log_pos 88330 CRC32 0x5ae92f93 	Table_map: `marigas`.`estoques` mapped to number 103
# has_generated_invisible_primary_key=0
# at 88330
#260415 10:36:30 server id 1  end_log_pos 88415 CRC32 0x323b8bab 	Write_rows: table id 103 flags: STMT_END_F
### INSERT INTO `marigas`.`estoques`
### SET
###   @1=1627
###   @2=4
###   @3=1
###   @4='entrada'
###   @5='compra'
###   @6=1776270990
###   @7=1776270990
###   @8=1776270990
# at 88415
#260415 10:36:30 server id 1  end_log_pos 88506 CRC32 0x7108e0a2 	Table_map: `marigas`.`produtos` mapped to number 89
# has_generated_invisible_primary_key=0
# at 88506
#260415 10:36:30 server id 1  end_log_pos 88688 CRC32 0xd6b92844 	Update_rows: table id 89 flags: STMT_END_F
### UPDATE `marigas`.`produtos`
### WHERE
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9902
###   @9='UNI'
###   @10=1768151301
###   @11=1776270825
###   @12=5
###   @13='999'
###   @14=NULL
### SET
###   @1=4
###   @2='PRODUTOS DIVERSOS'
###   @3=NULL
###   @4=1.00
###   @5=2.00
###   @6=0.00
###   @7=0.00
###   @8=9903
###   @9='UNI'
###   @10=1768151301
###   @11=1776270990
###   @12=5
###   @13='999'
###   @14=NULL
# at 88688
#260415 10:36:30 server id 1  end_log_pos 88779 CRC32 0xd89e475c 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 88779
#260415 10:36:30 server id 1  end_log_pos 88929 CRC32 0x3f353dc4 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6942
###   @2=565
###   @3='Compra de produtos - Parcela 1/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=1
###   @16=1
# at 88929
#260415 10:36:30 server id 1  end_log_pos 89020 CRC32 0x0c8e4dba 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 89020
#260415 10:36:30 server id 1  end_log_pos 89170 CRC32 0xa5e76c03 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6943
###   @2=565
###   @3='Compra de produtos - Parcela 2/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=2
###   @16=1
# at 89170
#260415 10:36:30 server id 1  end_log_pos 89261 CRC32 0xee4115b0 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 89261
#260415 10:36:30 server id 1  end_log_pos 89411 CRC32 0x5deb67ba 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6944
###   @2=565
###   @3='Compra de produtos - Parcela 3/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=3
###   @16=1
# at 89411
#260415 10:36:30 server id 1  end_log_pos 89502 CRC32 0xc1c7029b 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 89502
#260415 10:36:30 server id 1  end_log_pos 89652 CRC32 0x6a5032b3 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6945
###   @2=565
###   @3='Compra de produtos - Parcela 4/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=4
###   @16=1
# at 89652
#260415 10:36:30 server id 1  end_log_pos 89743 CRC32 0x4adb262b 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 89743
#260415 10:36:30 server id 1  end_log_pos 89893 CRC32 0x8e9afbdf 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6946
###   @2=565
###   @3='Compra de produtos - Parcela 5/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=5
###   @16=1
# at 89893
#260415 10:36:30 server id 1  end_log_pos 89984 CRC32 0x33d0c5bb 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 89984
#260415 10:36:30 server id 1  end_log_pos 90134 CRC32 0xf1002a10 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6947
###   @2=565
###   @3='Compra de produtos - Parcela 6/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=6
###   @16=1
# at 90134
#260415 10:36:30 server id 1  end_log_pos 90225 CRC32 0xa8cc8a2b 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 90225
#260415 10:36:30 server id 1  end_log_pos 90375 CRC32 0x87534290 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6948
###   @2=565
###   @3='Compra de produtos - Parcela 7/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=7
###   @16=1
# at 90375
#260415 10:36:30 server id 1  end_log_pos 90466 CRC32 0x02d7d431 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 90466
#260415 10:36:30 server id 1  end_log_pos 90616 CRC32 0x8c02ae73 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6949
###   @2=565
###   @3='Compra de produtos - Parcela 8/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=8
###   @16=1
# at 90616
#260415 10:36:30 server id 1  end_log_pos 90707 CRC32 0x0c56b9b0 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 90707
#260415 10:36:30 server id 1  end_log_pos 90857 CRC32 0x8b658930 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6950
###   @2=565
###   @3='Compra de produtos - Parcela 9/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=9
###   @16=1
# at 90857
#260415 10:36:30 server id 1  end_log_pos 90948 CRC32 0x8d906e44 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 90948
#260415 10:36:30 server id 1  end_log_pos 91099 CRC32 0xbeeb3041 	Write_rows: table id 90 flags: STMT_END_F
### INSERT INTO `marigas`.`contas_a_pagar`
### SET
###   @1=6951
###   @2=565
###   @3='Compra de produtos - Parcela 10/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=10
###   @16=1
# at 91099
#260415 10:36:30 server id 1  end_log_pos 91130 CRC32 0xb4326b68 	Xid = 17429
COMMIT/*!*/;
# at 91130
#260415 10:36:37 server id 1  end_log_pos 91209 CRC32 0x7dad4c76 	Anonymous_GTID	last_committed=87	sequence_number=88	rbr_only=yes	original_committed_timestamp=1776260197987725	immediate_commit_timestamp=1776260197987725	transaction_length=1550
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260197987725 (2026-04-15 10:36:37.987725 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260197987725 (2026-04-15 10:36:37.987725 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260197987725*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 91209
#260415 10:36:37 server id 1  end_log_pos 91304 CRC32 0x403c0500 	Query	thread_id=450	exec_time=0	error_code=0
SET TIMESTAMP=1776260197/*!*/;
BEGIN
/*!*/;
# at 91304
#260415 10:36:37 server id 1  end_log_pos 91395 CRC32 0x21a2016b 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 91395
#260415 10:36:37 server id 1  end_log_pos 92649 CRC32 0x69fbead1 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270935
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270997
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270935
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270997
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 92649
#260415 10:36:37 server id 1  end_log_pos 92680 CRC32 0x5ca92187 	Xid = 17502
COMMIT/*!*/;
# at 92680
#260415 10:36:37 server id 1  end_log_pos 92759 CRC32 0x72cb68b0 	Anonymous_GTID	last_committed=88	sequence_number=89	rbr_only=yes	original_committed_timestamp=1776260197990508	immediate_commit_timestamp=1776260197990508	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260197990508 (2026-04-15 10:36:37.990508 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260197990508 (2026-04-15 10:36:37.990508 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260197990508*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 92759
#260415 10:36:37 server id 1  end_log_pos 92854 CRC32 0x2a4eaa22 	Query	thread_id=450	exec_time=0	error_code=0
SET TIMESTAMP=1776260197/*!*/;
BEGIN
/*!*/;
# at 92854
#260415 10:36:37 server id 1  end_log_pos 92945 CRC32 0x15a6d9b7 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 92945
#260415 10:36:37 server id 1  end_log_pos 93439 CRC32 0x0300d7a2 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270935
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 93439
#260415 10:36:37 server id 1  end_log_pos 93470 CRC32 0xe34711d4 	Xid = 17505
COMMIT/*!*/;
# at 93470
#260415 10:36:42 server id 1  end_log_pos 93549 CRC32 0x64362497 	Anonymous_GTID	last_committed=89	sequence_number=90	rbr_only=yes	original_committed_timestamp=1776260202103117	immediate_commit_timestamp=1776260202103117	transaction_length=1550
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260202103117 (2026-04-15 10:36:42.103117 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260202103117 (2026-04-15 10:36:42.103117 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260202103117*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 93549
#260415 10:36:42 server id 1  end_log_pos 93644 CRC32 0xfd381f08 	Query	thread_id=451	exec_time=0	error_code=0
SET TIMESTAMP=1776260202/*!*/;
BEGIN
/*!*/;
# at 93644
#260415 10:36:42 server id 1  end_log_pos 93735 CRC32 0x07ce933a 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 93735
#260415 10:36:42 server id 1  end_log_pos 94989 CRC32 0x0748e65f 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776270997
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776271002
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776270997
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776271002
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 94989
#260415 10:36:42 server id 1  end_log_pos 95020 CRC32 0xa0e6bee4 	Xid = 17517
COMMIT/*!*/;
# at 95020
#260415 10:36:42 server id 1  end_log_pos 95099 CRC32 0x18a0096c 	Anonymous_GTID	last_committed=90	sequence_number=91	rbr_only=yes	original_committed_timestamp=1776260202106111	immediate_commit_timestamp=1776260202106111	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260202106111 (2026-04-15 10:36:42.106111 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260202106111 (2026-04-15 10:36:42.106111 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260202106111*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 95099
#260415 10:36:42 server id 1  end_log_pos 95194 CRC32 0xbf78d16d 	Query	thread_id=451	exec_time=0	error_code=0
SET TIMESTAMP=1776260202/*!*/;
BEGIN
/*!*/;
# at 95194
#260415 10:36:42 server id 1  end_log_pos 95285 CRC32 0x2625c3f5 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 95285
#260415 10:36:42 server id 1  end_log_pos 95779 CRC32 0x3be69f3c 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776270997
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 95779
#260415 10:36:42 server id 1  end_log_pos 95810 CRC32 0x1d31f3a4 	Xid = 17520
COMMIT/*!*/;
# at 95810
#260415 10:44:28 server id 1  end_log_pos 95890 CRC32 0xb1f54899 	Anonymous_GTID	last_committed=91	sequence_number=92	rbr_only=yes	original_committed_timestamp=1776260668257960	immediate_commit_timestamp=1776260668257960	transaction_length=76435
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260668257960 (2026-04-15 10:44:28.257960 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260668257960 (2026-04-15 10:44:28.257960 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260668257960*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 95890
#260415 10:44:28 server id 1  end_log_pos 95977 CRC32 0x11bcd7d3 	Query	thread_id=453	exec_time=0	error_code=0
SET TIMESTAMP=1776260668/*!*/;
/*!\C utf8mb4 *//*!*/;
SET @@session.character_set_client=255,@@session.collation_connection=255,@@session.collation_server=255/*!*/;
BEGIN
/*!*/;
# at 95977
#260415 10:44:28 server id 1  end_log_pos 96068 CRC32 0x5872b20c 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 96068
#260415 10:44:28 server id 1  end_log_pos 104172 CRC32 0x36ba5660 	Update_rows: table id 90
# at 104172
#260415 10:44:28 server id 1  end_log_pos 112274 CRC32 0x7e0a6186 	Update_rows: table id 90
# at 112274
#260415 10:44:28 server id 1  end_log_pos 120454 CRC32 0xd4f0bdc2 	Update_rows: table id 90
# at 120454
#260415 10:44:28 server id 1  end_log_pos 128656 CRC32 0x9b40d6e3 	Update_rows: table id 90
# at 128656
#260415 10:44:28 server id 1  end_log_pos 136790 CRC32 0x016abd27 	Update_rows: table id 90
# at 136790
#260415 10:44:28 server id 1  end_log_pos 144894 CRC32 0x9188aa4a 	Update_rows: table id 90
# at 144894
#260415 10:44:28 server id 1  end_log_pos 152916 CRC32 0x7832712e 	Update_rows: table id 90
# at 152916
#260415 10:44:28 server id 1  end_log_pos 161076 CRC32 0xfd823189 	Update_rows: table id 90
# at 161076
#260415 10:44:28 server id 1  end_log_pos 169168 CRC32 0x3bc161b6 	Update_rows: table id 90
# at 169168
#260415 10:44:28 server id 1  end_log_pos 172214 CRC32 0x44b82b31 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=2
###   @2=2
###   @3='Compra de produtos'
###   @4=3240.00
###   @5='2026:01:07'
###   @6='2026:01:17'
###   @7='2026:01:11'
###   @8=2
###   @9=5
###   @10=NULL
###   @11=1768075586
###   @12=1768251131
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=2
###   @2=2
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:07'
###   @6='2026:01:17'
###   @7='2026:01:11'
###   @8=2
###   @9=5
###   @10=NULL
###   @11=1768075586
###   @12=1768251131
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=3
###   @2=12
###   @3='Compra de produtos'
###   @4=1187.50
###   @5='2026:01:01'
###   @6='2026:01:02'
###   @7='2026:01:01'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768083175
###   @12=1768083175
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=3
###   @2=12
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:01'
###   @6='2026:01:02'
###   @7='2026:01:01'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768083175
###   @12=1768083175
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=4
###   @2=2
###   @3='Compra de produtos'
###   @4=720.00
###   @5='2026:01:10'
###   @6='2026:01:11'
###   @7='2026:01:10'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768090755
###   @12=1768090755
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=4
###   @2=2
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:10'
###   @6='2026:01:11'
###   @7='2026:01:10'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768090755
###   @12=1768090755
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6
###   @2=13
###   @3='Compra de produtos'
###   @4=500.00
###   @5='2026:01:11'
###   @6='2026:01:21'
###   @7='2026:01:17'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1768158031
###   @12=1768692221
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6
###   @2=13
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:11'
###   @6='2026:01:21'
###   @7='2026:01:17'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1768158031
###   @12=1768692221
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=8
###   @2=2
###   @3='Compra de produtos'
###   @4=3600.00
###   @5='2026:01:12'
###   @6='2026:01:22'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768250668
###   @12=1768692089
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=8
###   @2=2
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:12'
###   @6='2026:01:22'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768250668
###   @12=1768692089
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=10
###   @2=8
###   @3='MARMITA'
###   @4=25.00
###   @5='2026:01:12'
###   @6='2026:01:13'
###   @7='2026:01:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768260288
###   @12=1768260362
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=10
###   @2=8
###   @3='MARMITA'
###   @4=30.00
###   @5='2026:01:12'
###   @6='2026:01:13'
###   @7='2026:01:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768260288
###   @12=1768260362
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=11
###   @2=13
###   @3='Compra de produtos'
###   @4=100.00
###   @5='2026:01:12'
###   @6='2026:01:13'
###   @7='2026:01:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768260451
###   @12=1768260451
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=11
###   @2=13
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:12'
###   @6='2026:01:13'
###   @7='2026:01:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768260451
###   @12=1768260451
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=12
###   @2=13
###   @3='Compra de produtos'
###   @4=1.00
###   @5='2026:01:11'
###   @6='2026:01:12'
###   @7='2026:01:11'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768326592
###   @12=1768326592
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=12
###   @2=13
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:11'
###   @6='2026:01:12'
###   @7='2026:01:11'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768326592
###   @12=1768326592
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=13
###   @2=13
###   @3='Compra de produtos'
###   @4=0.30
###   @5='2026:01:12'
###   @6='2026:01:13'
###   @7='2026:01:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768326803
###   @12=1768326803
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=13
###   @2=13
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:12'
###   @6='2026:01:13'
###   @7='2026:01:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768326803
###   @12=1768326803
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=14
###   @2=12
###   @3='Compra de produtos'
###   @4=1424.70
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768691242
###   @12=1768691242
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=14
###   @2=12
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768691242
###   @12=1768691242
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=15
###   @2=13
###   @3='Compra de produtos'
###   @4=95.00
###   @5='2026:01:17'
###   @6='2026:01:20'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768691543
###   @12=1768692052
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=15
###   @2=13
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:20'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768691543
###   @12=1768692052
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=16
###   @2=12
###   @3='Compra de produtos'
###   @4=136.50
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1768691961
###   @12=1768691986
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=16
###   @2=12
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1768691961
###   @12=1768691986
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=17
###   @2=12
###   @3='Compra de produtos'
###   @4=180.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768692114
###   @12=1768692114
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=17
###   @2=12
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768692114
###   @12=1768692114
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=18
###   @2=13
###   @3='Compra de produtos'
###   @4=1402.20
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768692985
###   @12=1768693012
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=18
###   @2=13
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768692985
###   @12=1768693012
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=19
###   @2=2
###   @3='Compra de produtos'
###   @4=270.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768693089
###   @12=1768693089
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=19
###   @2=2
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768693089
###   @12=1768693089
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=20
###   @2=12
###   @3='Compra de produtos'
###   @4=90.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1768693184
###   @12=1768693209
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=20
###   @2=12
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1768693184
###   @12=1768693209
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=21
###   @2=2
###   @3='Compra de produtos'
###   @4=1350.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768693707
###   @12=1768693725
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=21
###   @2=2
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768693707
###   @12=1768693725
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=22
###   @2=12
###   @3='Compra de produtos'
###   @4=475.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768693746
###   @12=1768693746
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=22
###   @2=12
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768693746
###   @12=1768693746
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=25
###   @2=12
###   @3='Compra de produtos'
###   @4=450.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768694169
###   @12=1768694169
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=25
###   @2=12
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768694169
###   @12=1768694169
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=26
###   @2=13
###   @3='Compra de produtos'
###   @4=285.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1768694231
###   @12=1768694231
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=26
###   @2=13
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:19'
###   @7='2026:01:17'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1768694231
###   @12=1768694231
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=27
###   @2=2
###   @3='Compra de produtos'
###   @4=900.00
###   @5='2026:01:17'
###   @6='2026:01:20'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768694300
###   @12=1768694341
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=27
###   @2=2
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:17'
###   @6='2026:01:20'
###   @7='2026:01:17'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768694300
###   @12=1768694341
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=28
###   @2=13
###   @3='Compra de produtos'
###   @4=450.00
###   @5='2026:01:19'
###   @6='2026:01:21'
###   @7='2026:01:19'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768853704
###   @12=1768853704
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=28
###   @2=13
###   @3='Compra de produtos'
###   @4=30.00
###   @5='2026:01:19'
###   @6='2026:01:21'
###   @7='2026:01:19'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1768853704
###   @12=1768853704
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=32
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=1980.00
###   @5='2026:01:28'
###   @6='2026:02:07'
###   @7='2026:01:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1769897585
###   @12=1769897625
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=32
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:01:28'
###   @6='2026:02:07'
###   @7='2026:01:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1769897585
###   @12=1769897625
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=33
###   @2=11
###   @3='Compra de produtos - NF'
###   @4=3.00
###   @5='2026:01:31'
###   @6='2026:02:02'
###   @7='2026:01:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1769898290
###   @12=1769898354
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=33
###   @2=11
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:01:31'
###   @6='2026:02:02'
###   @7='2026:01:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1769898290
###   @12=1769898354
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=34
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=1980.00
###   @5='2026:01:28'
###   @6='2026:01:30'
###   @7='2026:01:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1769902319
###   @12=1769902349
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=34
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:01:28'
###   @6='2026:01:30'
###   @7='2026:01:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1769902319
###   @12=1769902349
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=36
###   @2=400
###   @3='CARTÃO CLICK'
###   @4=108.00
###   @5=NULL
###   @6='2025:12:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=36
###   @2=400
###   @3='CARTÃO CLICK'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=37
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=148.00
###   @5=NULL
###   @6='2025:12:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=37
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=38
###   @2=402
###   @3='PADARIA'
###   @4=45.00
###   @5=NULL
###   @6='2025:12:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=38
###   @2=402
###   @3='PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=39
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2025:12:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=39
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=40
###   @2=404
###   @3='KING HOST'
###   @4=95.84
###   @5=NULL
###   @6='2025:12:25'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=40
###   @2=404
###   @3='KING HOST'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:25'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=41
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2025:12:19'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=41
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:19'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=44
###   @2=408
###   @3='MARCIO AÇOUGUE'
###   @4=150.00
###   @5=NULL
###   @6='2025:12:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=44
###   @2=408
###   @3='MARCIO AÇOUGUE'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=45
###   @2=409
###   @3='MARIA'
###   @4=120.00
###   @5=NULL
###   @6='2025:12:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=45
###   @2=409
###   @3='MARIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=46
###   @2=402
###   @3='PADARIA'
###   @4=60.00
###   @5=NULL
###   @6='2025:12:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=46
###   @2=402
###   @3='PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=47
###   @2=411
###   @3='FATIMA/PADARIA'
###   @4=70.00
###   @5=NULL
###   @6='2025:12:21'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=47
###   @2=411
###   @3='FATIMA/PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:21'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=49
###   @2=402
###   @3='PADARIA'
###   @4=35.00
###   @5=NULL
###   @6='2025:12:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=49
###   @2=402
###   @3='PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=50
###   @2=414
###   @3='CLAUDIA / UNHA'
###   @4=55.00
###   @5=NULL
###   @6='2025:12:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=50
###   @2=414
###   @3='CLAUDIA / UNHA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=51
###   @2=415
###   @3='SORVETERIA'
###   @4=57.00
###   @5=NULL
###   @6='2025:12:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=51
###   @2=415
###   @3='SORVETERIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=52
###   @2=416
###   @3='MERCADO SOFIA'
###   @4=398.00
###   @5=NULL
###   @6='2025:12:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=52
###   @2=416
###   @3='MERCADO SOFIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=53
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=75.00
###   @5=NULL
###   @6='2025:12:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=53
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=54
###   @2=418
###   @3='PASTEL'
###   @4=60.00
###   @5=NULL
###   @6='2025:12:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=54
###   @2=418
###   @3='PASTEL'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=55
###   @2=419
###   @3='VANDERLEI/MOTO'
###   @4=70.00
###   @5=NULL
###   @6='2025:12:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=55
###   @2=419
###   @3='VANDERLEI/MOTO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=57
###   @2=421
###   @3='STRADA ABASTECIMENTO'
###   @4=50.00
###   @5=NULL
###   @6='2025:12:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=57
###   @2=421
###   @3='STRADA ABASTECIMENTO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=58
###   @2=422
###   @3='NATAL/MILENA'
###   @4=152.00
###   @5=NULL
###   @6='2025:12:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=58
###   @2=422
###   @3='NATAL/MILENA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=59
###   @2=421
###   @3='STRADA ABASTECIMENTO'
###   @4=50.00
###   @5=NULL
###   @6='2025:12:25'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=59
###   @2=421
###   @3='STRADA ABASTECIMENTO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:25'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=62
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=217.00
###   @5=NULL
###   @6='2025:12:26'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=62
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:26'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=64
###   @2=427
###   @3='FARMACIA SAO PAULO'
###   @4=70.00
###   @5=NULL
###   @6='2025:12:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=64
###   @2=427
###   @3='FARMACIA SAO PAULO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=65
###   @2=428
###   @3='FATIMA'
###   @4=70.00
###   @5=NULL
###   @6='2025:12:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=65
###   @2=428
###   @3='FATIMA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=66
###   @2=409
###   @3='MARIA'
###   @4=120.00
###   @5=NULL
###   @6='2025:12:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=66
###   @2=409
###   @3='MARIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=67
###   @2=402
###   @3='PADARIA'
###   @4=20.00
###   @5=NULL
###   @6='2025:12:28'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=67
###   @2=402
###   @3='PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:28'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=68
###   @2=431
###   @3='AÇOUGUE'
###   @4=45.00
###   @5=NULL
###   @6='2025:12:28'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=68
###   @2=431
###   @3='AÇOUGUE'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:28'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=69
###   @2=432
###   @3='COPEL'
###   @4=806.38
###   @5=NULL
###   @6='2025:01:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=69
###   @2=432
###   @3='COPEL'
###   @4=30.00
###   @5=NULL
###   @6='2025:01:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=70
###   @2=433
###   @3='JOGOS'
###   @4=100.00
###   @5=NULL
###   @6='2025:12:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=70
###   @2=433
###   @3='JOGOS'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=71
###   @2=434
###   @3='PARENTES'
###   @4=100.00
###   @5=NULL
###   @6='2025:12:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=71
###   @2=434
###   @3='PARENTES'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=72
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=50.00
###   @5=NULL
###   @6='2025:12:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=72
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=74
###   @2=403
###   @3='ALMOÇO'
###   @4=22.00
###   @5=NULL
###   @6='2025:12:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=74
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=75
###   @2=438
###   @3='IRPF/FATIMA'
###   @4=92.00
###   @5=NULL
###   @6='2025:12:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=75
###   @2=438
###   @3='IRPF/FATIMA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=76
###   @2=439
###   @3='RAMPA/MADEIRA'
###   @4=110.00
###   @5=NULL
###   @6='2025:12:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=76
###   @2=439
###   @3='RAMPA/MADEIRA'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=77
###   @2=440
###   @3='ABASTECIMENTO'
###   @4=50.00
###   @5=NULL
###   @6='2025:12:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=77
###   @2=440
###   @3='ABASTECIMENTO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=78
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2025:12:31'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=78
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2025:12:31'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=80
###   @2=442
###   @3='PUC MINAS'
###   @4=260.00
###   @5=NULL
###   @6='2026:01:15'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=80
###   @2=442
###   @3='PUC MINAS'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:15'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=82
###   @2=444
###   @3='CELULAR/MARI 06/12'
###   @4=260.00
###   @5=NULL
###   @6='2026:01:02'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=82
###   @2=444
###   @3='CELULAR/MARI 06/12'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:02'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=83
###   @2=445
###   @3='CASCO DO GÁS 04/12'
###   @4=150.00
###   @5=NULL
###   @6='2026:01:02'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=83
###   @2=445
###   @3='CASCO DO GÁS 04/12'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:02'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260011
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6371
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=1980.00
###   @5=NULL
###   @6='2026:02:12'
###   @7='2026:02:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770050289
###   @12=1770431509
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6371
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:12'
###   @7='2026:02:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770050289
###   @12=1770431509
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6372
###   @2=400
###   @3='CARTÃO CLICK'
###   @4=108.00
###   @5=NULL
###   @6='2026:01:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6372
###   @2=400
###   @3='CARTÃO CLICK'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6373
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=148.00
###   @5=NULL
###   @6='2026:01:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6373
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6374
###   @2=402
###   @3='PADARIA'
###   @4=45.00
###   @5=NULL
###   @6='2026:01:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6374
###   @2=402
###   @3='PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6375
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:01:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6375
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:18'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6376
###   @2=404
###   @3='KING HOST'
###   @4=95.84
###   @5=NULL
###   @6='2026:01:25'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6376
###   @2=404
###   @3='KING HOST'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:25'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6377
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:01:19'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6377
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:19'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6380
###   @2=408
###   @3='MARCIO AÇOUGUE'
###   @4=150.00
###   @5=NULL
###   @6='2026:01:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6380
###   @2=408
###   @3='MARCIO AÇOUGUE'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6381
###   @2=409
###   @3='MARIA'
###   @4=120.00
###   @5=NULL
###   @6='2026:01:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6381
###   @2=409
###   @3='MARIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6382
###   @2=402
###   @3='PADARIA'
###   @4=60.00
###   @5=NULL
###   @6='2026:01:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6382
###   @2=402
###   @3='PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:20'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6383
###   @2=411
###   @3='FATIMA/PADARIA'
###   @4=70.00
###   @5=NULL
###   @6='2026:01:21'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6383
###   @2=411
###   @3='FATIMA/PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:21'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6385
###   @2=402
###   @3='PADARIA'
###   @4=35.00
###   @5=NULL
###   @6='2026:01:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6385
###   @2=402
###   @3='PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6386
###   @2=414
###   @3='CLAUDIA / UNHA'
###   @4=55.00
###   @5=NULL
###   @6='2026:01:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6386
###   @2=414
###   @3='CLAUDIA / UNHA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6387
###   @2=415
###   @3='SORVETERIA'
###   @4=57.00
###   @5=NULL
###   @6='2026:01:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6387
###   @2=415
###   @3='SORVETERIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:22'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6388
###   @2=416
###   @3='MERCADO SOFIA'
###   @4=398.00
###   @5=NULL
###   @6='2026:01:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6388
###   @2=416
###   @3='MERCADO SOFIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6389
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=75.00
###   @5=NULL
###   @6='2026:01:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6389
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260725
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6390
###   @2=418
###   @3='PASTEL'
###   @4=60.00
###   @5=NULL
###   @6='2026:01:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6390
###   @2=418
###   @3='PASTEL'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:23'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6391
###   @2=419
###   @3='VANDERLEI/MOTO'
###   @4=70.00
###   @5=NULL
###   @6='2026:01:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6391
###   @2=419
###   @3='VANDERLEI/MOTO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6393
###   @2=421
###   @3='STRADA ABASTECIMENTO'
###   @4=50.00
###   @5=NULL
###   @6='2026:01:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6393
###   @2=421
###   @3='STRADA ABASTECIMENTO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6394
###   @2=422
###   @3='NATAL/MILENA'
###   @4=152.00
###   @5=NULL
###   @6='2026:01:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6394
###   @2=422
###   @3='NATAL/MILENA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:24'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6395
###   @2=421
###   @3='STRADA ABASTECIMENTO'
###   @4=50.00
###   @5=NULL
###   @6='2026:01:25'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6395
###   @2=421
###   @3='STRADA ABASTECIMENTO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:25'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6398
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=217.00
###   @5=NULL
###   @6='2026:01:26'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6398
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:26'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6400
###   @2=427
###   @3='FARMACIA SAO PAULO'
###   @4=70.00
###   @5=NULL
###   @6='2026:01:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6400
###   @2=427
###   @3='FARMACIA SAO PAULO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6401
###   @2=428
###   @3='FATIMA'
###   @4=70.00
###   @5=NULL
###   @6='2026:01:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6401
###   @2=428
###   @3='FATIMA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6402
###   @2=409
###   @3='MARIA'
###   @4=120.00
###   @5=NULL
###   @6='2026:01:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6402
###   @2=409
###   @3='MARIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:27'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6403
###   @2=402
###   @3='PADARIA'
###   @4=20.00
###   @5=NULL
###   @6='2026:01:28'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6403
###   @2=402
###   @3='PADARIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:28'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6404
###   @2=431
###   @3='AÇOUGUE'
###   @4=45.00
###   @5=NULL
###   @6='2026:01:28'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6404
###   @2=431
###   @3='AÇOUGUE'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:28'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6405
###   @2=433
###   @3='JOGOS'
###   @4=100.00
###   @5=NULL
###   @6='2026:01:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6405
###   @2=433
###   @3='JOGOS'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6406
###   @2=434
###   @3='PARENTES'
###   @4=100.00
###   @5=NULL
###   @6='2026:01:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6406
###   @2=434
###   @3='PARENTES'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6407
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=50.00
###   @5=NULL
###   @6='2026:01:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6407
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:29'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6409
###   @2=403
###   @3='ALMOÇO'
###   @4=22.00
###   @5=NULL
###   @6='2026:01:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6409
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6410
###   @2=438
###   @3='IRPF/FATIMA'
###   @4=92.00
###   @5=NULL
###   @6='2026:01:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6410
###   @2=438
###   @3='IRPF/FATIMA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6411
###   @2=439
###   @3='RAMPA/MADEIRA'
###   @4=110.00
###   @5=NULL
###   @6='2026:01:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6411
###   @2=439
###   @3='RAMPA/MADEIRA'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6412
###   @2=440
###   @3='ABASTECIMENTO'
###   @4=50.00
###   @5=NULL
###   @6='2026:01:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6412
###   @2=440
###   @3='ABASTECIMENTO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:30'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6413
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:01:31'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6413
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:01:31'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6415
###   @2=442
###   @3='PUC MINAS'
###   @4=260.00
###   @5=NULL
###   @6='2026:02:01'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260726
###   @12=1770764487
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6415
###   @2=442
###   @3='PUC MINAS'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:01'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260726
###   @12=1770764487
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6416
###   @2=443
###   @3='SEGURO DOS CARROS'
###   @4=430.00
###   @5=NULL
###   @6='2026:02:15'
###   @7='2026:02:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260726
###   @12=1770431230
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6416
###   @2=443
###   @3='SEGURO DOS CARROS'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:15'
###   @7='2026:02:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260726
###   @12=1770431230
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6417
###   @2=444
###   @3='CELULAR/MARI 06/12'
###   @4=260.00
###   @5=NULL
###   @6='2026:02:02'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6417
###   @2=444
###   @3='CELULAR/MARI 06/12'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:02'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6418
###   @2=445
###   @3='CASCO DO GÁS 04/12'
###   @4=150.00
###   @5=NULL
###   @6='2026:02:02'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6418
###   @2=445
###   @3='CASCO DO GÁS 04/12'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:02'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260726
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6420
###   @2=403
###   @3='ALMOÇO'
###   @4=45.00
###   @5=NULL
###   @6='2026:02:03'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6420
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:03'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6421
###   @2=494
###   @3='ABASTECIMENTO MOTO'
###   @4=50.00
###   @5=NULL
###   @6='2026:02:03'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6421
###   @2=494
###   @3='ABASTECIMENTO MOTO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:03'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6422
###   @2=495
###   @3='PORÇÃO'
###   @4=87.00
###   @5=NULL
###   @6='2026:02:04'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6422
###   @2=495
###   @3='PORÇÃO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:04'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6423
###   @2=496
###   @3='AÇAÍ'
###   @4=34.00
###   @5=NULL
###   @6='2026:02:04'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6423
###   @2=496
###   @3='AÇAÍ'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:04'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6424
###   @2=15
###   @3='MERCADO AMIGÃO'
###   @4=88.00
###   @5=NULL
###   @6='2026:02:04'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6424
###   @2=15
###   @3='MERCADO AMIGÃO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:04'
###   @7='2026:02:04'
###   @8=2
###   @9=NULL
###   @10=NULL
###   @11=1770260842
###   @12=1770320501
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6425
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:02:05'
###   @7='2026:02:06'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770431003
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6425
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:05'
###   @7='2026:02:06'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770431003
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6427
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:02:06'
###   @7='2026:02:06'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770431024
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6427
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:06'
###   @7='2026:02:06'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770431024
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6428
###   @2=500
###   @3='NUBANCK'
###   @4=412.96
###   @5=NULL
###   @6='2026:02:13'
###   @7='2026:02:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770767466
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6428
###   @2=500
###   @3='NUBANCK'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:13'
###   @7='2026:02:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770767466
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6429
###   @2=501
###   @3='EMPREST. CAIXA'
###   @4=493.00
###   @5=NULL
###   @6='2026:03:06'
###   @7='2026:03:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1772829270
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6429
###   @2=501
###   @3='EMPREST. CAIXA'
###   @4=30.00
###   @5=NULL
###   @6='2026:03:06'
###   @7='2026:03:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1772829270
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6433
###   @2=505
###   @3='RASTREADOR'
###   @4=59.90
###   @5=NULL
###   @6='2026:02:10'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770766454
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6433
###   @2=505
###   @3='RASTREADOR'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:10'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770766454
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6434
###   @2=506
###   @3='SERCOMTEL'
###   @4=49.90
###   @5=NULL
###   @6='2026:02:10'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770766471
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6434
###   @2=506
###   @3='SERCOMTEL'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:10'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770766471
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6435
###   @2=507
###   @3='LIGGA'
###   @4=109.90
###   @5=NULL
###   @6='2026:02:10'
###   @7=NULL
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770766481
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6435
###   @2=507
###   @3='LIGGA'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:10'
###   @7=NULL
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770766481
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6436
###   @2=508
###   @3='SANEPAR'
###   @4=196.56
###   @5=NULL
###   @6='2026:02:15'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770767397
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6436
###   @2=508
###   @3='SANEPAR'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:15'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770767397
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6439
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:02:08'
###   @7='2026:02:10'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770766210
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6439
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:08'
###   @7='2026:02:10'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770766210
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6440
###   @2=512
###   @3='PREVER/ITAU/'
###   @4=98.74
###   @5=NULL
###   @6='2026:02:09'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770748663
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6440
###   @2=512
###   @3='PREVER/ITAU/'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:09'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770748663
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6441
###   @2=513
###   @3='TIM'
###   @4=239.36
###   @5=NULL
###   @6='2026:02:09'
###   @7='2026:02:11'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770842123
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6441
###   @2=513
###   @3='TIM'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:09'
###   @7='2026:02:11'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770842123
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6442
###   @2=500
###   @3='EMPREST. NUBANCK'
###   @4=493.00
###   @5=NULL
###   @6='2026:02:25'
###   @7='2026:02:11'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770841877
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6442
###   @2=500
###   @3='EMPREST. NUBANCK'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:25'
###   @7='2026:02:11'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770841877
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6443
###   @2=15
###   @3='MERCADO AMIGÃO'
###   @4=163.64
###   @5=NULL
###   @6='2026:02:22'
###   @7='2026:02:12'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770908167
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6443
###   @2=15
###   @3='MERCADO AMIGÃO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:22'
###   @7='2026:02:12'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770908167
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6444
###   @2=403
###   @3='ALMOÇO'
###   @4=50.00
###   @5=NULL
###   @6='2026:02:09'
###   @7='2026:02:10'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770766244
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6444
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:09'
###   @7='2026:02:10'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770766244
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6450
###   @2=409
###   @3='MARIA'
###   @4=120.00
###   @5=NULL
###   @6='2026:02:14'
###   @7='2026:02:14'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1771346168
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6450
###   @2=409
###   @3='MARIA'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:14'
###   @7='2026:02:14'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1771346168
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6453
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:02:12'
###   @7='2026:02:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770908048
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6453
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:12'
###   @7='2026:02:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770908048
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6456
###   @2=527
###   @3='PRESTAÇÃO MOTO'
###   @4=585.00
###   @5=NULL
###   @6='2026:03:27'
###   @7='2026:03:12'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1770260842
###   @12=1773334553
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6456
###   @2=527
###   @3='PRESTAÇÃO MOTO'
###   @4=30.00
###   @5=NULL
###   @6='2026:03:27'
###   @7='2026:03:12'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1770260842
###   @12=1773334553
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6457
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=50.00
###   @5=NULL
###   @6='2026:02:13'
###   @7='2026:02:07'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1770260842
###   @12=1770484920
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6457
###   @2=401
###   @3='MERCADO MARCELO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:13'
###   @7='2026:02:07'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1770260842
###   @12=1770484920
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6458
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:02:13'
###   @7='2026:02:13'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770991165
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6458
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:13'
###   @7='2026:02:13'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770991165
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6461
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:02:14'
###   @7='2026:02:07'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770484833
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6461
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:14'
###   @7='2026:02:07'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770260842
###   @12=1770484833
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6462
###   @2=533
###   @3='GALÃO NOVO 3/12'
###   @4=135.00
###   @5=NULL
###   @6='2026:02:16'
###   @7='2026:02:06'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770431074
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6462
###   @2=533
###   @3='GALÃO NOVO 3/12'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:16'
###   @7='2026:02:06'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770431074
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6465
###   @2=402
###   @3='MERCADO AMIGÃO'
###   @4=40.00
###   @5=NULL
###   @6='2026:02:15'
###   @7='2026:02:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1771346263
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6465
###   @2=402
###   @3='MERCADO AMIGÃO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:15'
###   @7='2026:02:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1771346263
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6467
###   @2=496
###   @3='AÇAÍ'
###   @4=31.00
###   @5=NULL
###   @6='2026:02:16'
###   @7='2026:02:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1771346237
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6467
###   @2=496
###   @3='AÇAÍ'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:16'
###   @7='2026:02:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1771346237
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6469
###   @2=403
###   @3='ALMOÇO'
###   @4=25.00
###   @5=NULL
###   @6='2026:02:16'
###   @7='2026:02:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1771346219
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6469
###   @2=403
###   @3='ALMOÇO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:16'
###   @7='2026:02:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1771346219
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6470
###   @2=494
###   @3='ABASTECIMENTO MOTO'
###   @4=62.00
###   @5=NULL
###   @6='2026:02:12'
###   @7='2026:02:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770908997
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6470
###   @2=494
###   @3='ABASTECIMENTO MOTO'
###   @4=30.00
###   @5=NULL
###   @6='2026:02:12'
###   @7='2026:02:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1770260842
###   @12=1770908997
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6498
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=1980.00
###   @5='2026:02:04'
###   @6='2026:02:09'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770340079
###   @12=1770748692
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6498
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:02:04'
###   @6='2026:02:09'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770340079
###   @12=1770748692
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6499
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=2700.00
###   @5='2026:02:06'
###   @6='2026:02:12'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770431463
###   @12=1770766638
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6499
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:02:06'
###   @6='2026:02:12'
###   @7='2026:02:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770431463
###   @12=1770766638
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6500
###   @2=13
###   @3='Compra de produtos - NF'
###   @4=94.56
###   @5='2026:02:07'
###   @6='2026:02:08'
###   @7='2026:02:07'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770483948
###   @12=1770484762
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6500
###   @2=13
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:02:07'
###   @6='2026:02:08'
###   @7='2026:02:07'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770483948
###   @12=1770484762
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6501
###   @2=13
###   @3='Compra de produtos - NF'
###   @4=34.78
###   @5='2026:02:07'
###   @6='2026:02:08'
###   @7='2026:02:07'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1770486992
###   @12=1770487259
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6501
###   @2=13
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:02:07'
###   @6='2026:02:08'
###   @7='2026:02:07'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1770486992
###   @12=1770487259
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6502
###   @2=11
###   @3='ajustes'
###   @4=38.74
###   @5='2026:02:07'
###   @6='2026:02:08'
###   @7='2026:02:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1770487663
###   @12=1770487687
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6502
###   @2=11
###   @3='ajustes'
###   @4=30.00
###   @5='2026:02:07'
###   @6='2026:02:08'
###   @7='2026:02:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1770487663
###   @12=1770487687
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6503
###   @2=1
###   @3='ajustes'
###   @4=3.96
###   @5='2026:02:07'
###   @6='2026:02:08'
###   @7='2026:02:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1770487776
###   @12=1770487806
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6503
###   @2=1
###   @3='ajustes'
###   @4=30.00
###   @5='2026:02:07'
###   @6='2026:02:08'
###   @7='2026:02:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1770487776
###   @12=1770487806
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6504
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=2880.00
###   @5='2026:02:10'
###   @6='2026:02:16'
###   @7='2026:02:16'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770766612
###   @12=1771346208
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6504
###   @2=2
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:02:10'
###   @6='2026:02:16'
###   @7='2026:02:16'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770766612
###   @12=1771346208
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6505
###   @2=544
###   @3='Compra de produtos - NF'
###   @4=188.00
###   @5='2026:02:05'
###   @6='2026:02:15'
###   @7='2026:02:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770767615
###   @12=1770767644
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6505
###   @2=544
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:02:05'
###   @6='2026:02:15'
###   @7='2026:02:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770767615
###   @12=1770767644
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6507
###   @2=546
###   @3='CONVENIO'
###   @4=415.00
###   @5='2026:02:11'
###   @6='2026:02:25'
###   @7='2026:02:23'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1770830005
###   @12=1771876649
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6507
###   @2=546
###   @3='CONVENIO'
###   @4=30.00
###   @5='2026:02:11'
###   @6='2026:02:25'
###   @7='2026:02:23'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1770830005
###   @12=1771876649
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6508
###   @2=2
###   @3='Compra de produtos - NF 22 GAS'
###   @4=1980.00
###   @5='2026:02:13'
###   @6='2026:02:18'
###   @7='2026:02:18'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770991264
###   @12=1771365985
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6508
###   @2=2
###   @3='Compra de produtos - NF 22 GAS'
###   @4=30.00
###   @5='2026:02:13'
###   @6='2026:02:18'
###   @7='2026:02:18'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1770991264
###   @12=1771365985
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6509
###   @2=2
###   @3='Compra de produtos - NF 22 GAS'
###   @4=1980.00
###   @5='2026:02:17'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771365942
###   @12=1771874983
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6509
###   @2=2
###   @3='Compra de produtos - NF 22 GAS'
###   @4=30.00
###   @5='2026:02:17'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771365942
###   @12=1771874983
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6511
###   @2=12
###   @3='Compra de produtos - NF'
###   @4=240.70
###   @5='2026:02:19'
###   @6='2026:02:19'
###   @7='2026:02:19'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771540850
###   @12=1771540920
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6511
###   @2=12
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:02:19'
###   @6='2026:02:19'
###   @7='2026:02:19'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771540850
###   @12=1771540920
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6512
###   @2=12
###   @3='GALÃO NOVO 06/12'
###   @4=135.00
###   @5='2026:02:19'
###   @6='2026:02:20'
###   @7='2026:02:19'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771545932
###   @12=1771546167
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6512
###   @2=12
###   @3='GALÃO NOVO 06/12'
###   @4=30.00
###   @5='2026:02:19'
###   @6='2026:02:20'
###   @7='2026:02:19'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771545932
###   @12=1771546167
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6513
###   @2=2
###   @3='31 GAS'
###   @4=2790.00
###   @5='2026:02:22'
###   @6='2026:02:26'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771608098
###   @12=1771862152
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6513
###   @2=2
###   @3='31 GAS'
###   @4=30.00
###   @5='2026:02:22'
###   @6='2026:02:26'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771608098
###   @12=1771862152
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6514
###   @2=11
###   @3='MARIA'
###   @4=120.00
###   @5='2026:02:21'
###   @6='2026:02:21'
###   @7='2026:02:21'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771702595
###   @12=1771714926
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6514
###   @2=11
###   @3='MARIA'
###   @4=30.00
###   @5='2026:02:21'
###   @6='2026:02:21'
###   @7='2026:02:21'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771702595
###   @12=1771714926
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6516
###   @2=527
###   @3='PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:02:18'
###   @6='2026:02:27'
###   @7='2026:02:23'
###   @8=2
###   @9=3
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771876969
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6516
###   @2=527
###   @3='PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:27'
###   @7='2026:02:23'
###   @8=2
###   @9=3
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771876969
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6519
###   @2=551
###   @3='PSICÓLOGA'
###   @4=150.00
###   @5='2026:02:18'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=1
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771875027
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6519
###   @2=551
###   @3='PSICÓLOGA'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=1
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771875027
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6520
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=20.00
###   @5='2026:02:18'
###   @6='2026:02:19'
###   @7='2026:02:21'
###   @8=2
###   @9=4
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771716647
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6520
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:19'
###   @7='2026:02:21'
###   @8=2
###   @9=4
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771716647
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6521
###   @2=404
###   @3='KINGHOST'
###   @4=98.99
###   @5='2026:02:18'
###   @6='2026:02:24'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771876291
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6521
###   @2=404
###   @3='KINGHOST'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:24'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771876291
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6525
###   @2=548
###   @3='ALMOÇO'
###   @4=25.00
###   @5='2026:02:18'
###   @6='2026:02:21'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771857321
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6525
###   @2=548
###   @3='ALMOÇO'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:21'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771857321
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6526
###   @2=546
###   @3='CONVENIO'
###   @4=415.00
###   @5='2026:02:18'
###   @6='2026:03:25'
###   @7='2026:03:05'
###   @8=2
###   @9=3
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772717175
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6526
###   @2=546
###   @3='CONVENIO'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:03:25'
###   @7='2026:03:05'
###   @8=2
###   @9=3
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772717175
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6528
###   @2=548
###   @3='ALMOÇO'
###   @4=45.00
###   @5='2026:02:18'
###   @6='2026:02:22'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771857365
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6528
###   @2=548
###   @3='ALMOÇO'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:22'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771857365
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6529
###   @2=11
###   @3='TROCA DE PNEU/REMENDO'
###   @4=40.00
###   @5='2026:02:18'
###   @6='2026:02:22'
###   @7='2026:02:23'
###   @8=2
###   @9=5
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771857346
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6529
###   @2=11
###   @3='TROCA DE PNEU/REMENDO'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:22'
###   @7='2026:02:23'
###   @8=2
###   @9=5
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771857346
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6531
###   @2=548
###   @3='ALMOÇO'
###   @4=25.00
###   @5='2026:02:18'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771857428
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6531
###   @2=548
###   @3='ALMOÇO'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1771857428
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6535
###   @2=548
###   @3='ALMOÇO'
###   @4=28.00
###   @5='2026:02:18'
###   @6='2026:02:26'
###   @7='2026:02:26'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772111801
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6535
###   @2=548
###   @3='ALMOÇO'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:26'
###   @7='2026:02:26'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772111801
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6539
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=311.00
###   @5='2026:02:18'
###   @6='2026:02:27'
###   @7='2026:02:27'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772244379
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6539
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:27'
###   @7='2026:02:27'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772244379
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6544
###   @2=11
###   @3='SEGURO  EMPRÉSTIMO'
###   @4=25.88
###   @5='2026:02:18'
###   @6='2026:02:25'
###   @7='2026:02:25'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772031664
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6544
###   @2=11
###   @3='SEGURO  EMPRÉSTIMO'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:25'
###   @7='2026:02:25'
###   @8=2
###   @9=2
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772031664
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6546
###   @2=11
###   @3='DESPESAS DIVERSAS'
###   @4=66.00
###   @5='2026:02:18'
###   @6='2026:02:27'
###   @7='2026:02:27'
###   @8=2
###   @9=1
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772201913
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6546
###   @2=11
###   @3='DESPESAS DIVERSAS'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:02:27'
###   @7='2026:02:27'
###   @8=2
###   @9=1
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1772201913
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6564
###   @2=432
###   @3='COPEL'
###   @4=949.08
###   @5='2026:02:18'
###   @6='2026:03:18'
###   @7='2026:03:12'
###   @8=2
###   @9=3
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1773331764
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6564
###   @2=432
###   @3='COPEL'
###   @4=30.00
###   @5='2026:02:18'
###   @6='2026:03:18'
###   @7='2026:03:12'
###   @8=2
###   @9=3
###   @10='Importado via planilha MARÇO/26'
###   @11=1771704996
###   @12=1773331764
###   @13=0
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6621
###   @2=11
###   @3='MARI - MC DONALD'
###   @4=14.50
###   @5='2026:02:22'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771859073
###   @12=1771859108
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6621
###   @2=11
###   @3='MARI - MC DONALD'
###   @4=30.00
###   @5='2026:02:22'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771859073
###   @12=1771859108
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6622
###   @2=551
###   @3='Compra de produtos - NF PSICÓLOGA'
###   @4=150.00
###   @5='2026:02:23'
###   @6='2026:03:02'
###   @7='2026:02:23'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771875092
###   @12=1773091914
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6622
###   @2=551
###   @3='Compra de produtos - NF PSICÓLOGA'
###   @4=30.00
###   @5='2026:02:23'
###   @6='2026:03:02'
###   @7='2026:02:23'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771875092
###   @12=1773091914
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6623
###   @2=8
###   @3='REST. DO ADILSON'
###   @4=25.00
###   @5='2026:02:23'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771875276
###   @12=1771875323
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6623
###   @2=8
###   @3='REST. DO ADILSON'
###   @4=30.00
###   @5='2026:02:23'
###   @6='2026:02:23'
###   @7='2026:02:23'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771875276
###   @12=1771875323
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6624
###   @2=12
###   @3='COMPRA  66 AGUAS'
###   @4=627.00
###   @5='2026:02:23'
###   @6='2026:02:24'
###   @7='2026:02:24'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771860719
###   @12=1771961295
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6624
###   @2=12
###   @3='COMPRA  66 AGUAS'
###   @4=30.00
###   @5='2026:02:23'
###   @6='2026:02:24'
###   @7='2026:02:24'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771860719
###   @12=1771961295
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6625
###   @2=12
###   @3='GALÃO NOVO 07/12'
###   @4=135.00
###   @5='2025:11:20'
###   @6='2026:02:25'
###   @7='2026:02:24'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771861700
###   @12=1771961320
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6625
###   @2=12
###   @3='GALÃO NOVO 07/12'
###   @4=30.00
###   @5='2025:11:20'
###   @6='2026:02:25'
###   @7='2026:02:24'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1771861700
###   @12=1771961320
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6626
###   @2=548
###   @3='ALMOÇO -TILÁPIA'
###   @4=32.00
###   @5='2026:02:24'
###   @6='2026:02:25'
###   @7='2026:02:25'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771956388
###   @12=1772041843
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6626
###   @2=548
###   @3='ALMOÇO -TILÁPIA'
###   @4=30.00
###   @5='2026:02:24'
###   @6='2026:02:25'
###   @7='2026:02:25'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771956388
###   @12=1772041843
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6628
###   @2=424
###   @3='Compra de produtos - NF conta vencimento 26/02/26'
###   @4=71.40
###   @5='2026:02:24'
###   @6='2026:02:26'
###   @7='2026:02:24'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771975707
###   @12=1771975748
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6628
###   @2=424
###   @3='Compra de produtos - NF conta vencimento 26/02/26'
###   @4=30.00
###   @5='2026:02:24'
###   @6='2026:02:26'
###   @7='2026:02:24'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1771975707
###   @12=1771975748
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6629
###   @2=2
###   @3='22 GAS'
###   @4=1500.00
###   @5='2026:02:25'
###   @6='2026:02:28'
###   @7='2026:02:27'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772024594
###   @12=1772198600
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6629
###   @2=2
###   @3='22 GAS'
###   @4=30.00
###   @5='2026:02:25'
###   @6='2026:02:28'
###   @7='2026:02:27'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772024594
###   @12=1772198600
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6631
###   @2=2
###   @3='Compra de produtos - NF 22 GAS - certos'
###   @4=480.00
###   @5='2026:02:27'
###   @6='2026:02:27'
###   @7='2026:02:27'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772199099
###   @12=1772199147
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6631
###   @2=2
###   @3='Compra de produtos - NF 22 GAS - certos'
###   @4=30.00
###   @5='2026:02:27'
###   @6='2026:02:27'
###   @7='2026:02:27'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772199099
###   @12=1772199147
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6632
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:02:27'
###   @6='2026:02:27'
###   @7='2026:02:27'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772199496
###   @12=1772199515
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6632
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=30.00
###   @5='2026:02:27'
###   @6='2026:02:27'
###   @7='2026:02:27'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772199496
###   @12=1772199515
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6633
###   @2=11
###   @3='FATIMA - MATO'
###   @4=50.00
###   @5='2026:02:27'
###   @6='2026:03:01'
###   @7='2026:02:27'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772201747
###   @12=1772201811
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6633
###   @2=11
###   @3='FATIMA - MATO'
###   @4=30.00
###   @5='2026:02:27'
###   @6='2026:03:01'
###   @7='2026:02:27'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772201747
###   @12=1772201811
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6634
###   @2=2
###   @3='Compra de produtos - NF 34 GAS'
###   @4=3060.00
###   @5='2026:02:27'
###   @6='2026:03:05'
###   @7='2026:03:02'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772288788
###   @12=1772465251
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6634
###   @2=2
###   @3='Compra de produtos - NF 34 GAS'
###   @4=30.00
###   @5='2026:02:27'
###   @6='2026:03:05'
###   @7='2026:03:02'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772288788
###   @12=1772465251
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6635
###   @2=2
###   @3='NF AJUSTE DO CAIXA 28-02'
###   @4=480.00
###   @5='2026:02:28'
###   @6='2026:02:28'
###   @7='2026:02:28'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772286492
###   @12=1772286547
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6635
###   @2=2
###   @3='NF AJUSTE DO CAIXA 28-02'
###   @4=30.00
###   @5='2026:02:28'
###   @6='2026:02:28'
###   @7='2026:02:28'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772286492
###   @12=1772286547
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6641
###   @2=409
###   @3='DIARISTA'
###   @4=120.00
###   @5='2026:03:01'
###   @6='2026:03:07'
###   @7='2026:03:07'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772380135
###   @12=1772918715
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6641
###   @2=409
###   @3='DIARISTA'
###   @4=30.00
###   @5='2026:03:01'
###   @6='2026:03:07'
###   @7='2026:03:07'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772380135
###   @12=1772918715
###   @13=10
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6642
###   @2=545
###   @3='PRO LABORE'
###   @4=333.96
###   @5='2026:03:01'
###   @6='2026:03:15'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772391615
###   @12=1773079534
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6642
###   @2=545
###   @3='PRO LABORE'
###   @4=30.00
###   @5='2026:03:01'
###   @6='2026:03:15'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772391615
###   @12=1773079534
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6643
###   @2=558
###   @3='Compra de produtos - NF'
###   @4=275.00
###   @5='2026:03:01'
###   @6='2026:03:06'
###   @7='2026:03:04'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772391802
###   @12=1772675747
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6643
###   @2=558
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:03:01'
###   @6='2026:03:06'
###   @7='2026:03:04'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772391802
###   @12=1772675747
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6646
###   @2=559
###   @3='PRESTACAO HB-20'
###   @4=688.00
###   @5='2026:03:02'
###   @6='2026:03:05'
###   @7='2026:03:04'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772472550
###   @12=1772675813
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6646
###   @2=559
###   @3='PRESTACAO HB-20'
###   @4=30.00
###   @5='2026:03:02'
###   @6='2026:03:05'
###   @7='2026:03:04'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772472550
###   @12=1772675813
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6647
###   @2=2
###   @3='NF 57.179'
###   @4=2880.00
###   @5='2026:03:03'
###   @6='2026:03:06'
###   @7='2026:03:05'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772560133
###   @12=1772720410
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6647
###   @2=2
###   @3='NF 57.179'
###   @4=30.00
###   @5='2026:03:03'
###   @6='2026:03:06'
###   @7='2026:03:05'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772560133
###   @12=1772720410
###   @13=3
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6648
###   @2=548
###   @3='ALMOÇO 04/03'
###   @4=32.00
###   @5='2026:03:04'
###   @6='2026:03:04'
###   @7='2026:03:04'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772634710
###   @12=1772649667
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6648
###   @2=548
###   @3='ALMOÇO 04/03'
###   @4=30.00
###   @5='2026:03:04'
###   @6='2026:03:04'
###   @7='2026:03:04'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772634710
###   @12=1772649667
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6649
###   @2=548
###   @3='NF ALMOÇO 05/03'
###   @4=27.00
###   @5='2026:03:04'
###   @6='2026:03:05'
###   @7='2026:03:05'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772634743
###   @12=1772751607
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6649
###   @2=548
###   @3='NF ALMOÇO 05/03'
###   @4=30.00
###   @5='2026:03:04'
###   @6='2026:03:05'
###   @7='2026:03:05'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772634743
###   @12=1772751607
###   @13=2
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6667
###   @2=500
###   @3='Compra de produtos - Parcela 1/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1775602211
###   @13=30
###   @14=182
###   @15=1
###   @16=1
### SET
###   @1=6667
###   @2=500
###   @3='Compra de produtos - Parcela 1/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1775602211
###   @13=30
###   @14=182
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6668
###   @2=500
###   @3='Compra de produtos - Parcela 2/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=2
###   @16=1
### SET
###   @1=6668
###   @2=500
###   @3='Compra de produtos - Parcela 2/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6669
###   @2=500
###   @3='Compra de produtos - Parcela 3/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=3
###   @16=1
### SET
###   @1=6669
###   @2=500
###   @3='Compra de produtos - Parcela 3/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6670
###   @2=500
###   @3='Compra de produtos - Parcela 4/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=4
###   @16=1
### SET
###   @1=6670
###   @2=500
###   @3='Compra de produtos - Parcela 4/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6671
###   @2=500
###   @3='Compra de produtos - Parcela 5/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=5
###   @16=1
### SET
###   @1=6671
###   @2=500
###   @3='Compra de produtos - Parcela 5/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6672
###   @2=500
###   @3='Compra de produtos - Parcela 6/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=6
###   @16=1
### SET
###   @1=6672
###   @2=500
###   @3='Compra de produtos - Parcela 6/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6673
###   @2=500
###   @3='Compra de produtos - Parcela 7/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:10:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=7
###   @16=1
### SET
###   @1=6673
###   @2=500
###   @3='Compra de produtos - Parcela 7/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:10:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6674
###   @2=500
###   @3='Compra de produtos - Parcela 8/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:10:31'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=8
###   @16=1
### SET
###   @1=6674
###   @2=500
###   @3='Compra de produtos - Parcela 8/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:10:31'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6675
###   @2=500
###   @3='Compra de produtos - Parcela 9/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:11:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=9
###   @16=1
### SET
###   @1=6675
###   @2=500
###   @3='Compra de produtos - Parcela 9/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:11:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6676
###   @2=500
###   @3='Compra de produtos - Parcela 10/10 - NF NETFLEX'
###   @4=20.90
###   @5='2026:03:05'
###   @6='2026:12:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=10
###   @16=1
### SET
###   @1=6676
###   @2=500
###   @3='Compra de produtos - Parcela 10/10 - NF NETFLEX'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:12:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772749093
###   @12=1772749093
###   @13=30
###   @14=182
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6677
###   @2=500
###   @3='Compra de produtos - Parcela 1/2 - NF REGI/MARI'
###   @4=65.27
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749144
###   @12=1775602218
###   @13=30
###   @14=183
###   @15=1
###   @16=1
### SET
###   @1=6677
###   @2=500
###   @3='Compra de produtos - Parcela 1/2 - NF REGI/MARI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749144
###   @12=1775602218
###   @13=30
###   @14=183
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6678
###   @2=500
###   @3='Compra de produtos - Parcela 2/2 - NF REGI/MARI'
###   @4=65.27
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749144
###   @12=1772749144
###   @13=30
###   @14=183
###   @15=2
###   @16=1
### SET
###   @1=6678
###   @2=500
###   @3='Compra de produtos - Parcela 2/2 - NF REGI/MARI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749144
###   @12=1772749144
###   @13=30
###   @14=183
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6679
###   @2=500
###   @3='Compra de produtos - Parcela 1/3 - NF DANKI CURSOS'
###   @4=20.37
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749197
###   @12=1775602227
###   @13=30
###   @14=184
###   @15=1
###   @16=1
### SET
###   @1=6679
###   @2=500
###   @3='Compra de produtos - Parcela 1/3 - NF DANKI CURSOS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749197
###   @12=1775602227
###   @13=30
###   @14=184
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6680
###   @2=500
###   @3='Compra de produtos - Parcela 2/3 - NF DANKI CURSOS'
###   @4=20.37
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749197
###   @12=1772749197
###   @13=30
###   @14=184
###   @15=2
###   @16=1
### SET
###   @1=6680
###   @2=500
###   @3='Compra de produtos - Parcela 2/3 - NF DANKI CURSOS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749197
###   @12=1772749197
###   @13=30
###   @14=184
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6681
###   @2=500
###   @3='Compra de produtos - Parcela 3/3 - NF DANKI CURSOS'
###   @4=20.37
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749197
###   @12=1772749197
###   @13=30
###   @14=184
###   @15=3
###   @16=1
### SET
###   @1=6681
###   @2=500
###   @3='Compra de produtos - Parcela 3/3 - NF DANKI CURSOS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749197
###   @12=1772749197
###   @13=30
###   @14=184
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6686
###   @2=500
###   @3='Compra de produtos - Parcela 1/3 - NF AMAZON / REGI'
###   @4=51.40
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749431
###   @12=1775602233
###   @13=30
###   @14=186
###   @15=1
###   @16=1
### SET
###   @1=6686
###   @2=500
###   @3='Compra de produtos - Parcela 1/3 - NF AMAZON / REGI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749431
###   @12=1775602233
###   @13=30
###   @14=186
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6687
###   @2=500
###   @3='Compra de produtos - Parcela 2/3 - NF AMAZON / REGI'
###   @4=51.40
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749431
###   @12=1772749431
###   @13=30
###   @14=186
###   @15=2
###   @16=1
### SET
###   @1=6687
###   @2=500
###   @3='Compra de produtos - Parcela 2/3 - NF AMAZON / REGI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749431
###   @12=1772749431
###   @13=30
###   @14=186
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6688
###   @2=500
###   @3='Compra de produtos - Parcela 3/3 - NF AMAZON / REGI'
###   @4=51.40
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749431
###   @12=1772749431
###   @13=30
###   @14=186
###   @15=3
###   @16=1
### SET
###   @1=6688
###   @2=500
###   @3='Compra de produtos - Parcela 3/3 - NF AMAZON / REGI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749431
###   @12=1772749431
###   @13=30
###   @14=186
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6689
###   @2=500
###   @3='Compra de produtos - Parcela 1/4 - NF AMAZON 4/8 MARI'
###   @4=112.37
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749495
###   @12=1775602242
###   @13=30
###   @14=187
###   @15=1
###   @16=1
### SET
###   @1=6689
###   @2=500
###   @3='Compra de produtos - Parcela 1/4 - NF AMAZON 4/8 MARI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749495
###   @12=1775602242
###   @13=30
###   @14=187
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6690
###   @2=500
###   @3='Compra de produtos - Parcela 2/4 - NF AMAZON 4/8 MARI'
###   @4=112.37
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749495
###   @12=1772749495
###   @13=30
###   @14=187
###   @15=2
###   @16=1
### SET
###   @1=6690
###   @2=500
###   @3='Compra de produtos - Parcela 2/4 - NF AMAZON 4/8 MARI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749495
###   @12=1772749495
###   @13=30
###   @14=187
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6691
###   @2=500
###   @3='Compra de produtos - Parcela 3/4 - NF AMAZON 4/8 MARI'
###   @4=112.37
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749495
###   @12=1772749495
###   @13=30
###   @14=187
###   @15=3
###   @16=1
### SET
###   @1=6691
###   @2=500
###   @3='Compra de produtos - Parcela 3/4 - NF AMAZON 4/8 MARI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749495
###   @12=1772749495
###   @13=30
###   @14=187
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6692
###   @2=500
###   @3='Compra de produtos - Parcela 4/4 - NF AMAZON 4/8 MARI'
###   @4=112.37
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749495
###   @12=1772749495
###   @13=30
###   @14=187
###   @15=4
###   @16=1
### SET
###   @1=6692
###   @2=500
###   @3='Compra de produtos - Parcela 4/4 - NF AMAZON 4/8 MARI'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749495
###   @12=1772749495
###   @13=30
###   @14=187
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6693
###   @2=500
###   @3='Compra de produtos - Parcela 1/6 - NF LOJA DA CASA'
###   @4=42.92
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1775602249
###   @13=30
###   @14=188
###   @15=1
###   @16=1
### SET
###   @1=6693
###   @2=500
###   @3='Compra de produtos - Parcela 1/6 - NF LOJA DA CASA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1775602249
###   @13=30
###   @14=188
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6694
###   @2=500
###   @3='Compra de produtos - Parcela 2/6 - NF LOJA DA CASA'
###   @4=42.92
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=2
###   @16=1
### SET
###   @1=6694
###   @2=500
###   @3='Compra de produtos - Parcela 2/6 - NF LOJA DA CASA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6695
###   @2=500
###   @3='Compra de produtos - Parcela 3/6 - NF LOJA DA CASA'
###   @4=42.92
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=3
###   @16=1
### SET
###   @1=6695
###   @2=500
###   @3='Compra de produtos - Parcela 3/6 - NF LOJA DA CASA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6696
###   @2=500
###   @3='Compra de produtos - Parcela 4/6 - NF LOJA DA CASA'
###   @4=42.92
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=4
###   @16=1
### SET
###   @1=6696
###   @2=500
###   @3='Compra de produtos - Parcela 4/6 - NF LOJA DA CASA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6697
###   @2=500
###   @3='Compra de produtos - Parcela 5/6 - NF LOJA DA CASA'
###   @4=42.92
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=5
###   @16=1
### SET
###   @1=6697
###   @2=500
###   @3='Compra de produtos - Parcela 5/6 - NF LOJA DA CASA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6698
###   @2=500
###   @3='Compra de produtos - Parcela 6/6 - NF LOJA DA CASA'
###   @4=42.92
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=6
###   @16=1
### SET
###   @1=6698
###   @2=500
###   @3='Compra de produtos - Parcela 6/6 - NF LOJA DA CASA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772749546
###   @12=1772749546
###   @13=30
###   @14=188
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6699
###   @2=500
###   @3='Compra de produtos - Parcela 1/1 - NF MARIGAS'
###   @4=100.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749593
###   @12=1775602337
###   @13=30
###   @14=189
###   @15=1
###   @16=1
### SET
###   @1=6699
###   @2=500
###   @3='Compra de produtos - Parcela 1/1 - NF MARIGAS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1772749593
###   @12=1775602337
###   @13=30
###   @14=189
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6700
###   @2=443
###   @3='Compra de produtos - Parcela 1/1 - NF SEGURO DOS CARROS'
###   @4=430.00
###   @5='2026:03:05'
###   @6='2026:03:15'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772749865
###   @12=1773079035
###   @13=10
###   @14=191
###   @15=1
###   @16=1
### SET
###   @1=6700
###   @2=443
###   @3='Compra de produtos - Parcela 1/1 - NF SEGURO DOS CARROS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:03:15'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772749865
###   @12=1773079035
###   @13=10
###   @14=191
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6701
###   @2=508
###   @3='Compra de produtos - Parcela 1/1 - NF AGUA'
###   @4=196.56
###   @5='2026:03:05'
###   @6='2026:03:15'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772749902
###   @12=1773079015
###   @13=10
###   @14=192
###   @15=1
###   @16=1
### SET
###   @1=6701
###   @2=508
###   @3='Compra de produtos - Parcela 1/1 - NF AGUA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:03:15'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772749902
###   @12=1773079015
###   @13=10
###   @14=192
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6702
###   @2=507
###   @3='Compra de produtos - Parcela 1/1 - NF INTERNET'
###   @4=109.90
###   @5='2026:03:05'
###   @6='2026:03:10'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750025
###   @12=1773079242
###   @13=5
###   @14=193
###   @15=1
###   @16=1
### SET
###   @1=6702
###   @2=507
###   @3='Compra de produtos - Parcela 1/1 - NF INTERNET'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:03:10'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750025
###   @12=1773079242
###   @13=5
###   @14=193
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6703
###   @2=506
###   @3='Compra de produtos - Parcela 1/1 - NF TELEFONE FIXO'
###   @4=49.90
###   @5='2026:03:05'
###   @6='2026:03:10'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750111
###   @12=1773079339
###   @13=1
###   @14=194
###   @15=1
###   @16=1
### SET
###   @1=6703
###   @2=506
###   @3='Compra de produtos - Parcela 1/1 - NF TELEFONE FIXO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:03:10'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750111
###   @12=1773079339
###   @13=1
###   @14=194
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6704
###   @2=512
###   @3='Compra de produtos - Parcela 1/1 - NF PREVER'
###   @4=98.00
###   @5='2026:03:05'
###   @6='2026:03:10'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750165
###   @12=1773079052
###   @13=5
###   @14=195
###   @15=1
###   @16=1
### SET
###   @1=6704
###   @2=512
###   @3='Compra de produtos - Parcela 1/1 - NF PREVER'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:03:10'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750165
###   @12=1773079052
###   @13=5
###   @14=195
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6705
###   @2=444
###   @3='Compra de produtos - Parcela 1/4 - NF CELULAR /MARI/WILLIAN'
###   @4=258.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750322
###   @12=1775577468
###   @13=30
###   @14=197
###   @15=1
###   @16=1
### SET
###   @1=6705
###   @2=444
###   @3='Compra de produtos - Parcela 1/4 - NF CELULAR /MARI/WILLIAN'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750322
###   @12=1775577468
###   @13=30
###   @14=197
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6706
###   @2=444
###   @3='Compra de produtos - Parcela 2/4 - NF CELULAR /MARI/WILLIAN'
###   @4=258.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772750322
###   @12=1772750322
###   @13=30
###   @14=197
###   @15=2
###   @16=1
### SET
###   @1=6706
###   @2=444
###   @3='Compra de produtos - Parcela 2/4 - NF CELULAR /MARI/WILLIAN'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772750322
###   @12=1772750322
###   @13=30
###   @14=197
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6707
###   @2=444
###   @3='Compra de produtos - Parcela 3/4 - NF CELULAR /MARI/WILLIAN'
###   @4=258.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772750322
###   @12=1772750322
###   @13=30
###   @14=197
###   @15=3
###   @16=1
### SET
###   @1=6707
###   @2=444
###   @3='Compra de produtos - Parcela 3/4 - NF CELULAR /MARI/WILLIAN'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772750322
###   @12=1772750322
###   @13=30
###   @14=197
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6708
###   @2=444
###   @3='Compra de produtos - Parcela 4/4 - NF CELULAR /MARI/WILLIAN'
###   @4=258.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772750322
###   @12=1772750322
###   @13=30
###   @14=197
###   @15=4
###   @16=1
### SET
###   @1=6708
###   @2=444
###   @3='Compra de produtos - Parcela 4/4 - NF CELULAR /MARI/WILLIAN'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=4
###   @10=NULL
###   @11=1772750322
###   @12=1772750322
###   @13=30
###   @14=197
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6709
###   @2=501
###   @3='NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1775602040
###   @13=30
###   @14=198
###   @15=1
###   @16=1
### SET
###   @1=6709
###   @2=501
###   @3='NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1775602040
###   @13=30
###   @14=198
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6710
###   @2=501
###   @3='Compra de produtos - Parcela 2/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=2
###   @16=1
### SET
###   @1=6710
###   @2=501
###   @3='Compra de produtos - Parcela 2/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6711
###   @2=501
###   @3='Compra de produtos - Parcela 3/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=3
###   @16=1
### SET
###   @1=6711
###   @2=501
###   @3='Compra de produtos - Parcela 3/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6712
###   @2=501
###   @3='Compra de produtos - Parcela 4/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=4
###   @16=1
### SET
###   @1=6712
###   @2=501
###   @3='Compra de produtos - Parcela 4/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6713
###   @2=501
###   @3='Compra de produtos - Parcela 5/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=5
###   @16=1
### SET
###   @1=6713
###   @2=501
###   @3='Compra de produtos - Parcela 5/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6714
###   @2=501
###   @3='Compra de produtos - Parcela 6/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=6
###   @16=1
### SET
###   @1=6714
###   @2=501
###   @3='Compra de produtos - Parcela 6/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6715
###   @2=501
###   @3='Compra de produtos - Parcela 7/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:10:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=7
###   @16=1
### SET
###   @1=6715
###   @2=501
###   @3='Compra de produtos - Parcela 7/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:10:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6716
###   @2=501
###   @3='Compra de produtos - Parcela 8/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:10:31'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=8
###   @16=1
### SET
###   @1=6716
###   @2=501
###   @3='Compra de produtos - Parcela 8/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:10:31'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6717
###   @2=501
###   @3='Compra de produtos - Parcela 9/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:11:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=9
###   @16=1
### SET
###   @1=6717
###   @2=501
###   @3='Compra de produtos - Parcela 9/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:11:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6718
###   @2=501
###   @3='Compra de produtos - Parcela 10/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2026:12:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=10
###   @16=1
### SET
###   @1=6718
###   @2=501
###   @3='Compra de produtos - Parcela 10/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:12:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6719
###   @2=501
###   @3='Compra de produtos - Parcela 11/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2027:01:29'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=11
###   @16=1
### SET
###   @1=6719
###   @2=501
###   @3='Compra de produtos - Parcela 11/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2027:01:29'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=11
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6720
###   @2=501
###   @3='Compra de produtos - Parcela 12/12 - NF MILENA / EMPREST / CAIXA'
###   @4=493.00
###   @5='2026:03:05'
###   @6='2027:02:28'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=12
###   @16=1
### SET
###   @1=6720
###   @2=501
###   @3='Compra de produtos - Parcela 12/12 - NF MILENA / EMPREST / CAIXA'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2027:02:28'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772750473
###   @12=1772750473
###   @13=30
###   @14=198
###   @15=12
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6721
###   @2=505
###   @3='Compra de produtos - Parcela 1/1 - NF RASTREADOR MOTO'
###   @4=59.90
###   @5='2026:03:05'
###   @6='2026:03:10'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750649
###   @12=1773078991
###   @13=5
###   @14=199
###   @15=1
###   @16=1
### SET
###   @1=6721
###   @2=505
###   @3='Compra de produtos - Parcela 1/1 - NF RASTREADOR MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:03:10'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750649
###   @12=1773078991
###   @13=5
###   @14=199
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6722
###   @2=445
###   @3='Parcela 6/12  - NF CASCO'
###   @4=150.00
###   @5='2026:03:05'
###   @6='2026:03:09'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750825
###   @12=1773088631
###   @13=4
###   @14=200
###   @15=1
###   @16=1
### SET
###   @1=6722
###   @2=445
###   @3='Parcela 6/12  - NF CASCO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:03:09'
###   @7='2026:03:09'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1772750825
###   @12=1773088631
###   @13=4
###   @14=200
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6724
###   @2=445
###   @3='Compra de produtos - Parcela 2/6 - NF CASCO DO GÁS'
###   @4=150.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=2
###   @16=1
### SET
###   @1=6724
###   @2=445
###   @3='Compra de produtos - Parcela 2/6 - NF CASCO DO GÁS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6725
###   @2=445
###   @3='Compra de produtos - Parcela 3/6 - NF CASCO DO GÁS'
###   @4=150.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=3
###   @16=1
### SET
###   @1=6725
###   @2=445
###   @3='Compra de produtos - Parcela 3/6 - NF CASCO DO GÁS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6726
###   @2=445
###   @3='Compra de produtos - Parcela 4/6 - NF CASCO DO GÁS'
###   @4=150.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=4
###   @16=1
### SET
###   @1=6726
###   @2=445
###   @3='Compra de produtos - Parcela 4/6 - NF CASCO DO GÁS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6727
###   @2=445
###   @3='Compra de produtos - Parcela 5/6 - NF CASCO DO GÁS'
###   @4=150.00
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=5
###   @16=1
### SET
###   @1=6727
###   @2=445
###   @3='Compra de produtos - Parcela 5/6 - NF CASCO DO GÁS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6728
###   @2=445
###   @3='Compra de produtos - Parcela 6/6 - NF CASCO DO GÁS'
###   @4=150.00
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=6
###   @16=1
### SET
###   @1=6728
###   @2=445
###   @3='Compra de produtos - Parcela 6/6 - NF CASCO DO GÁS'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772750875
###   @12=1772750875
###   @13=30
###   @14=201
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6732
###   @2=527
###   @3='Compra de produtos - Parcela 2/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=2
###   @16=1
### SET
###   @1=6732
###   @2=527
###   @3='Compra de produtos - Parcela 2/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:05:04'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6733
###   @2=527
###   @3='Compra de produtos - Parcela 3/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=3
###   @16=1
### SET
###   @1=6733
###   @2=527
###   @3='Compra de produtos - Parcela 3/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:06:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6734
###   @2=527
###   @3='Compra de produtos - Parcela 4/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=4
###   @16=1
### SET
###   @1=6734
###   @2=527
###   @3='Compra de produtos - Parcela 4/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:07:03'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6735
###   @2=527
###   @3='Compra de produtos - Parcela 5/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=5
###   @16=1
### SET
###   @1=6735
###   @2=527
###   @3='Compra de produtos - Parcela 5/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:08:02'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6736
###   @2=527
###   @3='Compra de produtos - Parcela 6/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=6
###   @16=1
### SET
###   @1=6736
###   @2=527
###   @3='Compra de produtos - Parcela 6/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6737
###   @2=527
###   @3='Compra de produtos - Parcela 7/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:10:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=7
###   @16=1
### SET
###   @1=6737
###   @2=527
###   @3='Compra de produtos - Parcela 7/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:10:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6738
###   @2=527
###   @3='Compra de produtos - Parcela 8/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:10:31'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=8
###   @16=1
### SET
###   @1=6738
###   @2=527
###   @3='Compra de produtos - Parcela 8/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:10:31'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6739
###   @2=527
###   @3='Compra de produtos - Parcela 9/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:11:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=9
###   @16=1
### SET
###   @1=6739
###   @2=527
###   @3='Compra de produtos - Parcela 9/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:11:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6740
###   @2=527
###   @3='Compra de produtos - Parcela 10/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2026:12:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=10
###   @16=1
### SET
###   @1=6740
###   @2=527
###   @3='Compra de produtos - Parcela 10/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:12:30'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6741
###   @2=527
###   @3='Compra de produtos - Parcela 11/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2027:01:29'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=11
###   @16=1
### SET
###   @1=6741
###   @2=527
###   @3='Compra de produtos - Parcela 11/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2027:01:29'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=11
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6742
###   @2=527
###   @3='Compra de produtos - Parcela 12/12 - NF PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:05'
###   @6='2027:02:28'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=12
###   @16=1
### SET
###   @1=6742
###   @2=527
###   @3='Compra de produtos - Parcela 12/12 - NF PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2027:02:28'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1772751146
###   @12=1772751146
###   @13=30
###   @14=204
###   @15=12
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6743
###   @2=404
###   @3='Compra de produtos - Parcela 1/1 - NF KING HOST'
###   @4=98.99
###   @5='2026:03:05'
###   @6='2026:03:18'
###   @7='2026:03:18'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772751716
###   @12=1773846370
###   @13=20
###   @14=205
###   @15=1
###   @16=1
### SET
###   @1=6743
###   @2=404
###   @3='Compra de produtos - Parcela 1/1 - NF KING HOST'
###   @4=30.00
###   @5='2026:03:05'
###   @6='2026:03:18'
###   @7='2026:03:18'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1772751716
###   @12=1773846370
###   @13=20
###   @14=205
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6744
###   @2=560
###   @3='Compra de produtos - Parcela 1/1 - NF BANCO ITAU'
###   @4=4000.00
###   @5='2026:03:06'
###   @6='2026:04:30'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772815069
###   @12=1775748705
###   @13=1
###   @14=209
###   @15=1
###   @16=1
### SET
###   @1=6744
###   @2=560
###   @3='Compra de produtos - Parcela 1/1 - NF BANCO ITAU'
###   @4=30.00
###   @5='2026:03:06'
###   @6='2026:04:30'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1772815069
###   @12=1775748705
###   @13=1
###   @14=209
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6745
###   @2=2
###   @3='- NF 22 GAS'
###   @4=1300.00
###   @5='2026:03:06'
###   @6='2026:03:13'
###   @7='2026:03:08'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772815191
###   @12=1772983384
###   @13=7
###   @14=210
###   @15=1
###   @16=1
### SET
###   @1=6745
###   @2=2
###   @3='- NF 22 GAS'
###   @4=30.00
###   @5='2026:03:06'
###   @6='2026:03:13'
###   @7='2026:03:08'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1772815191
###   @12=1772983384
###   @13=7
###   @14=210
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6746
###   @2=551
###   @3='Compra de produtos - Parcela 1/1 - NF PSICÓLOGA'
###   @4=150.00
###   @5='2026:03:09'
###   @6='2026:03:16'
###   @7='2026:03:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773070879
###   @12=1773670344
###   @13=1
###   @14=233
###   @15=1
###   @16=1
### SET
###   @1=6746
###   @2=551
###   @3='Compra de produtos - Parcela 1/1 - NF PSICÓLOGA'
###   @4=30.00
###   @5='2026:03:09'
###   @6='2026:03:16'
###   @7='2026:03:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773070879
###   @12=1773670344
###   @13=1
###   @14=233
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6747
###   @2=409
###   @3='DIARISTA'
###   @4=120.00
###   @5='2026:03:09'
###   @6='2026:03:14'
###   @7='2026:03:14'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773091975
###   @12=1773496543
###   @13=1
###   @14=237
###   @15=1
###   @16=1
### SET
###   @1=6747
###   @2=409
###   @3='DIARISTA'
###   @4=30.00
###   @5='2026:03:09'
###   @6='2026:03:14'
###   @7='2026:03:14'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773091975
###   @12=1773496543
###   @13=1
###   @14=237
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6748
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF 22 GÁS - NF. 57.249'
###   @4=1000.00
###   @5='2026:03:10'
###   @6='2026:03:13'
###   @7='2026:03:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773163528
###   @12=1773333390
###   @13=1
###   @14=242
###   @15=1
###   @16=1
### SET
###   @1=6748
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF 22 GÁS - NF. 57.249'
###   @4=30.00
###   @5='2026:03:10'
###   @6='2026:03:13'
###   @7='2026:03:12'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773163528
###   @12=1773333390
###   @13=1
###   @14=242
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6750
###   @2=513
###   @3='Compra de produtos - Parcela 1/1 - NF'
###   @4=239.96
###   @5='2026:03:10'
###   @6='2026:03:18'
###   @7='2026:03:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773165544
###   @12=1773165845
###   @13=1
###   @14=244
###   @15=1
###   @16=1
### SET
###   @1=6750
###   @2=513
###   @3='Compra de produtos - Parcela 1/1 - NF'
###   @4=30.00
###   @5='2026:03:10'
###   @6='2026:03:18'
###   @7='2026:03:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773165544
###   @12=1773165845
###   @13=1
###   @14=244
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6752
###   @2=2
###   @3='22 GAS - NF. 57.265'
###   @4=500.00
###   @5='2026:03:11'
###   @6='2026:03:16'
###   @7='2026:03:15'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773261422
###   @12=1773587985
###   @13=1
###   @14=254
###   @15=1
###   @16=1
### SET
###   @1=6752
###   @2=2
###   @3='22 GAS - NF. 57.265'
###   @4=30.00
###   @5='2026:03:11'
###   @6='2026:03:16'
###   @7='2026:03:15'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773261422
###   @12=1773587985
###   @13=1
###   @14=254
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6753
###   @2=442
###   @3='Compra de produtos - Parcela 1/12 - NF PARCELAS'
###   @4=265.93
###   @5='2026:02:01'
###   @6='2026:03:03'
###   @7='2026:03:12'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329044
###   @13=30
###   @14=258
###   @15=1
###   @16=1
### SET
###   @1=6753
###   @2=442
###   @3='Compra de produtos - Parcela 1/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:03:03'
###   @7='2026:03:12'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329044
###   @13=30
###   @14=258
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6754
###   @2=442
###   @3='PUC MINAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:04:01'
###   @7='2026:03:30'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1774884479
###   @13=30
###   @14=258
###   @15=2
###   @16=1
### SET
###   @1=6754
###   @2=442
###   @3='PUC MINAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:04:01'
###   @7='2026:03:30'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1774884479
###   @13=30
###   @14=258
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6755
###   @2=442
###   @3='Compra de produtos - Parcela 3/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:05:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329103
###   @13=30
###   @14=258
###   @15=3
###   @16=1
### SET
###   @1=6755
###   @2=442
###   @3='Compra de produtos - Parcela 3/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:05:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329103
###   @13=30
###   @14=258
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6756
###   @2=442
###   @3='Compra de produtos - Parcela 4/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:06:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773327331
###   @13=30
###   @14=258
###   @15=4
###   @16=1
### SET
###   @1=6756
###   @2=442
###   @3='Compra de produtos - Parcela 4/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:06:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773327331
###   @13=30
###   @14=258
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6757
###   @2=442
###   @3='Compra de produtos - Parcela 5/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:07:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773327331
###   @13=30
###   @14=258
###   @15=5
###   @16=1
### SET
###   @1=6757
###   @2=442
###   @3='Compra de produtos - Parcela 5/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:07:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773327331
###   @13=30
###   @14=258
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6758
###   @2=442
###   @3='Compra de produtos - Parcela 6/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:08:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329123
###   @13=30
###   @14=258
###   @15=6
###   @16=1
### SET
###   @1=6758
###   @2=442
###   @3='Compra de produtos - Parcela 6/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:08:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329123
###   @13=30
###   @14=258
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6759
###   @2=442
###   @3='Compra de produtos - Parcela 7/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329132
###   @13=30
###   @14=258
###   @15=7
###   @16=1
### SET
###   @1=6759
###   @2=442
###   @3='Compra de produtos - Parcela 7/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:09:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329132
###   @13=30
###   @14=258
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6760
###   @2=442
###   @3='Compra de produtos - Parcela 8/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:10:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329144
###   @13=30
###   @14=258
###   @15=8
###   @16=1
### SET
###   @1=6760
###   @2=442
###   @3='Compra de produtos - Parcela 8/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:10:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329144
###   @13=30
###   @14=258
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6761
###   @2=442
###   @3='Compra de produtos - Parcela 9/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:11:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329158
###   @13=30
###   @14=258
###   @15=9
###   @16=1
### SET
###   @1=6761
###   @2=442
###   @3='Compra de produtos - Parcela 9/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:11:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329158
###   @13=30
###   @14=258
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6762
###   @2=442
###   @3='Compra de produtos - Parcela 10/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2026:12:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329166
###   @13=30
###   @14=258
###   @15=10
###   @16=1
### SET
###   @1=6762
###   @2=442
###   @3='Compra de produtos - Parcela 10/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2026:12:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329166
###   @13=30
###   @14=258
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6763
###   @2=442
###   @3='Compra de produtos - Parcela 11/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2027:01:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329187
###   @13=30
###   @14=258
###   @15=11
###   @16=1
### SET
###   @1=6763
###   @2=442
###   @3='Compra de produtos - Parcela 11/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2027:01:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329187
###   @13=30
###   @14=258
###   @15=11
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6764
###   @2=442
###   @3='Compra de produtos - Parcela 12/12 - NF PARCELAS'
###   @4=260.00
###   @5='2026:02:01'
###   @6='2027:02:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329195
###   @13=30
###   @14=258
###   @15=12
###   @16=1
### SET
###   @1=6764
###   @2=442
###   @3='Compra de produtos - Parcela 12/12 - NF PARCELAS'
###   @4=30.00
###   @5='2026:02:01'
###   @6='2027:02:01'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1773327331
###   @12=1773329195
###   @13=30
###   @14=258
###   @15=12
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6765
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF rederente a comrpa do dia 10/03'
###   @4=980.00
###   @5='2026:03:12'
###   @6='2026:03:13'
###   @7='2026:03:12'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773333781
###   @12=1773333801
###   @13=1
###   @14=260
###   @15=1
###   @16=1
### SET
###   @1=6765
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF rederente a comrpa do dia 10/03'
###   @4=30.00
###   @5='2026:03:12'
###   @6='2026:03:13'
###   @7='2026:03:12'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773333781
###   @12=1773333801
###   @13=1
###   @14=260
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6766
###   @2=2
###   @3='NF 18 GAS  NF. 57.281'
###   @4=3100.00
###   @5='2026:03:12'
###   @6='2026:03:16'
###   @7='2026:03:15'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773335050
###   @12=1773588011
###   @13=1
###   @14=261
###   @15=1
###   @16=1
### SET
###   @1=6766
###   @2=2
###   @3='NF 18 GAS  NF. 57.281'
###   @4=30.00
###   @5='2026:03:12'
###   @6='2026:03:16'
###   @7='2026:03:15'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773335050
###   @12=1773588011
###   @13=1
###   @14=261
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6767
###   @2=440
###   @3='31  AGUA'
###   @4=712.88
###   @5='2026:03:12'
###   @6='2026:04:16'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1773337019
###   @12=1776266160
###   @13=1
###   @14=262
###   @15=1
###   @16=1
### SET
###   @1=6767
###   @2=440
###   @3='31  AGUA'
###   @4=30.00
###   @5='2026:03:12'
###   @6='2026:04:16'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1773337019
###   @12=1776266160
###   @13=1
###   @14=262
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6768
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:13'
###   @6='2026:03:13'
###   @7='2026:03:13'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773412604
###   @12=1773412642
###   @13=1
###   @14=268
###   @15=1
###   @16=1
### SET
###   @1=6768
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=30.00
###   @5='2026:03:13'
###   @6='2026:03:13'
###   @7='2026:03:13'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773412604
###   @12=1773412642
###   @13=1
###   @14=268
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6771
###   @2=8
###   @3='ADILSON RESTAURANTE'
###   @4=25.00
###   @5='2026:03:13'
###   @6='2026:03:16'
###   @7='2026:03:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773414990
###   @12=1773670637
###   @13=1
###   @14=269
###   @15=3
###   @16=1
### SET
###   @1=6771
###   @2=8
###   @3='ADILSON RESTAURANTE'
###   @4=30.00
###   @5='2026:03:13'
###   @6='2026:03:16'
###   @7='2026:03:16'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773414990
###   @12=1773670637
###   @13=1
###   @14=269
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6772
###   @2=548
###   @3='Compra de produtos - Parcela 4/12 - NF ALMOÇO'
###   @4=26.00
###   @5='2026:03:13'
###   @6='2026:03:17'
###   @7='2026:03:17'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773414990
###   @12=1773791338
###   @13=1
###   @14=269
###   @15=4
###   @16=1
### SET
###   @1=6772
###   @2=548
###   @3='Compra de produtos - Parcela 4/12 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:03:13'
###   @6='2026:03:17'
###   @7='2026:03:17'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773414990
###   @12=1773791338
###   @13=1
###   @14=269
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6774
###   @2=548
###   @3='Compra de produtos - Parcela 6/12 - NF ALMOÇO'
###   @4=0.01
###   @5='2026:03:13'
###   @6='2026:03:19'
###   @7='2026:03:20'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773414990
###   @12=1774016212
###   @13=1
###   @14=269
###   @15=6
###   @16=1
### SET
###   @1=6774
###   @2=548
###   @3='Compra de produtos - Parcela 6/12 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:03:13'
###   @6='2026:03:19'
###   @7='2026:03:20'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773414990
###   @12=1774016212
###   @13=1
###   @14=269
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6778
###   @2=8
###   @3='REST. ADILSON'
###   @4=22.00
###   @5='2026:03:13'
###   @6='2026:03:23'
###   @7='2026:03:23'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773414990
###   @12=1774303561
###   @13=1
###   @14=269
###   @15=10
###   @16=1
### SET
###   @1=6778
###   @2=8
###   @3='REST. ADILSON'
###   @4=30.00
###   @5='2026:03:13'
###   @6='2026:03:23'
###   @7='2026:03:23'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773414990
###   @12=1774303561
###   @13=1
###   @14=269
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6779
###   @2=548
###   @3='Compra de produtos - Parcela 11/12 - NF ALMOÇO'
###   @4=27.00
###   @5='2026:03:13'
###   @6='2026:03:24'
###   @7='2026:03:24'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773414990
###   @12=1774358340
###   @13=1
###   @14=269
###   @15=11
###   @16=1
### SET
###   @1=6779
###   @2=548
###   @3='Compra de produtos - Parcela 11/12 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:03:13'
###   @6='2026:03:24'
###   @7='2026:03:24'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773414990
###   @12=1774358340
###   @13=1
###   @14=269
###   @15=11
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6781
###   @2=428
###   @3='DESPESAS DIVERSAS'
###   @4=100.00
###   @5='2026:03:14'
###   @6='2026:03:15'
###   @7='2026:03:14'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773496697
###   @12=1773496775
###   @13=1
###   @14=275
###   @15=1
###   @16=1
### SET
###   @1=6781
###   @2=428
###   @3='DESPESAS DIVERSAS'
###   @4=30.00
###   @5='2026:03:14'
###   @6='2026:03:15'
###   @7='2026:03:14'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1773496697
###   @12=1773496775
###   @13=1
###   @14=275
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6782
###   @2=2
###   @3='21 GÁS NF.'
###   @4=1890.00
###   @5='2026:03:16'
###   @6='2026:03:19'
###   @7='2026:03:18'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773675171
###   @12=1773845349
###   @13=3
###   @14=282
###   @15=1
###   @16=1
### SET
###   @1=6782
###   @2=2
###   @3='21 GÁS NF.'
###   @4=30.00
###   @5='2026:03:16'
###   @6='2026:03:19'
###   @7='2026:03:18'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773675171
###   @12=1773845349
###   @13=3
###   @14=282
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6784
###   @2=2
###   @3='22 gás'
###   @4=1980.00
###   @5='2026:03:18'
###   @6='2026:03:23'
###   @7='2026:03:22'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773861407
###   @12=1774189097
###   @13=4
###   @14=292
###   @15=1
###   @16=1
### SET
###   @1=6784
###   @2=2
###   @3='22 gás'
###   @4=30.00
###   @5='2026:03:18'
###   @6='2026:03:23'
###   @7='2026:03:22'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1773861407
###   @12=1774189097
###   @13=4
###   @14=292
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6786
###   @2=567
###   @3='Compra de produtos - Parcela 1/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:04:19'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=1
###   @16=1
### SET
###   @1=6786
###   @2=567
###   @3='Compra de produtos - Parcela 1/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:04:19'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6787
###   @2=567
###   @3='Compra de produtos - Parcela 2/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:05:19'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=2
###   @16=1
### SET
###   @1=6787
###   @2=567
###   @3='Compra de produtos - Parcela 2/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:05:19'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6788
###   @2=567
###   @3='Compra de produtos - Parcela 3/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:06:18'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=3
###   @16=1
### SET
###   @1=6788
###   @2=567
###   @3='Compra de produtos - Parcela 3/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:06:18'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6789
###   @2=567
###   @3='Compra de produtos - Parcela 4/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:07:18'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=4
###   @16=1
### SET
###   @1=6789
###   @2=567
###   @3='Compra de produtos - Parcela 4/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:07:18'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6790
###   @2=567
###   @3='Compra de produtos - Parcela 5/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:08:17'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=5
###   @16=1
### SET
###   @1=6790
###   @2=567
###   @3='Compra de produtos - Parcela 5/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:08:17'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6791
###   @2=567
###   @3='Compra de produtos - Parcela 6/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:09:16'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=6
###   @16=1
### SET
###   @1=6791
###   @2=567
###   @3='Compra de produtos - Parcela 6/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:09:16'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6792
###   @2=567
###   @3='Compra de produtos - Parcela 7/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:10:16'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=7
###   @16=1
### SET
###   @1=6792
###   @2=567
###   @3='Compra de produtos - Parcela 7/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:10:16'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6793
###   @2=567
###   @3='Compra de produtos - Parcela 8/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:11:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=8
###   @16=1
### SET
###   @1=6793
###   @2=567
###   @3='Compra de produtos - Parcela 8/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:11:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6794
###   @2=567
###   @3='Compra de produtos - Parcela 9/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:12:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=9
###   @16=1
### SET
###   @1=6794
###   @2=567
###   @3='Compra de produtos - Parcela 9/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:12:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6795
###   @2=567
###   @3='Compra de produtos - Parcela 10/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2027:01:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=10
###   @16=1
### SET
###   @1=6795
###   @2=567
###   @3='Compra de produtos - Parcela 10/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2027:01:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6796
###   @2=567
###   @3='Compra de produtos - Parcela 11/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2027:02:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=11
###   @16=1
### SET
###   @1=6796
###   @2=567
###   @3='Compra de produtos - Parcela 11/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2027:02:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=11
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6797
###   @2=567
###   @3='Compra de produtos - Parcela 12/12 - NF ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2027:03:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=12
###   @16=1
### SET
###   @1=6797
###   @2=567
###   @3='Compra de produtos - Parcela 12/12 - NF ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2027:03:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1774016588
###   @12=1774016588
###   @13=30
###   @14=296
###   @15=12
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6798
###   @2=567
###   @3='ITAU SEGURO/FINANC.'
###   @4=25.88
###   @5='2026:03:20'
###   @6='2026:03:21'
###   @7='2026:03:20'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1774016672
###   @12=1774016703
###   @13=1
###   @14=297
###   @15=1
###   @16=1
### SET
###   @1=6798
###   @2=567
###   @3='ITAU SEGURO/FINANC.'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:03:21'
###   @7='2026:03:20'
###   @8=2
###   @9=3
###   @10=NULL
###   @11=1774016672
###   @12=1774016703
###   @13=1
###   @14=297
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6799
###   @2=409
###   @3='DIARISTA'
###   @4=120.00
###   @5='2026:03:20'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1774027470
###   @12=1774027726
###   @13=1
###   @14=298
###   @15=1
###   @16=1
### SET
###   @1=6799
###   @2=409
###   @3='DIARISTA'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1774027470
###   @12=1774027726
###   @13=1
###   @14=298
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6800
###   @2=409
###   @3='DIARISTA'
###   @4=120.00
###   @5='2026:03:20'
###   @6='2026:03:28'
###   @7='2026:03:28'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774027492
###   @12=1774705384
###   @13=1
###   @14=299
###   @15=1
###   @16=1
### SET
###   @1=6800
###   @2=409
###   @3='DIARISTA'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:03:28'
###   @7='2026:03:28'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774027492
###   @12=1774705384
###   @13=1
###   @14=299
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6803
###   @2=409
###   @3='DIARISTA'
###   @4=120.00
###   @5='2026:03:20'
###   @6='2026:03:21'
###   @7='2026:03:21'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774027709
###   @12=1774102070
###   @13=1
###   @14=302
###   @15=1
###   @16=1
### SET
###   @1=6803
###   @2=409
###   @3='DIARISTA'
###   @4=30.00
###   @5='2026:03:20'
###   @6='2026:03:21'
###   @7='2026:03:21'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774027709
###   @12=1774102070
###   @13=1
###   @14=302
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6812
###   @2=551
###   @3='PSICÓLOGA'
###   @4=150.00
###   @5='2026:03:19'
###   @6='2026:03:30'
###   @7='2026:03:30'
###   @8=2
###   @9=1
###   @10='Importado da planilha. Código fornecedor: 551'
###   @11=1774030440
###   @12=1774882782
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6812
###   @2=551
###   @3='PSICÓLOGA'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:03:30'
###   @7='2026:03:30'
###   @8=2
###   @9=1
###   @10='Importado da planilha. Código fornecedor: 551'
###   @11=1774030440
###   @12=1774882782
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6815
###   @2=424
###   @3='FATURA VIVO'
###   @4=71.00
###   @5='2026:03:19'
###   @6='2026:03:24'
###   @7='2026:03:25'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 424'
###   @11=1774030440
###   @12=1774448717
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6815
###   @2=424
###   @3='FATURA VIVO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:03:24'
###   @7='2026:03:25'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 424'
###   @11=1774030440
###   @12=1774448717
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6819
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=228.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7='2026:03:28'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 417'
###   @11=1774030440
###   @12=1774705458
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6819
###   @2=417
###   @3='MERCADO BOM DIA'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7='2026:03:28'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 417'
###   @11=1774030440
###   @12=1774705458
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=42.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776271002
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776271002
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6821
###   @2=558
###   @3='Compra de produtos - NF'
###   @4=275.00
###   @5='2026:03:19'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 558'
###   @11=1774030440
###   @12=1775577483
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6821
###   @2=558
###   @3='Compra de produtos - NF'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:04'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 558'
###   @11=1774030440
###   @12=1775577483
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6822
###   @2=559
###   @3='PRESTACAO HB-20'
###   @4=688.00
###   @5='2026:03:19'
###   @6='2026:04:04'
###   @7='2026:04:06'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 559'
###   @11=1774030440
###   @12=1775490307
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6822
###   @2=559
###   @3='PRESTACAO HB-20'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:04'
###   @7='2026:04:06'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 559'
###   @11=1774030440
###   @12=1775490307
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6823
###   @2=546
###   @3='CONVENIO'
###   @4=2087.00
###   @5='2026:03:19'
###   @6='2026:04:05'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 546'
###   @11=1774030440
###   @12=1775577499
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6823
###   @2=546
###   @3='CONVENIO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:05'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 546'
###   @11=1774030440
###   @12=1775577499
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6826
###   @2=445
###   @3='Parcela 6/12  - NF CASCO'
###   @4=150.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 445'
###   @11=1774030440
###   @12=1775835635
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6826
###   @2=445
###   @3='Parcela 6/12  - NF CASCO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 445'
###   @11=1774030440
###   @12=1775835635
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6827
###   @2=507
###   @3='Compra de produtos - Parcela 1/1 - NF INTERNET'
###   @4=109.90
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 507'
###   @11=1774030440
###   @12=1775577522
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6827
###   @2=507
###   @3='Compra de produtos - Parcela 1/1 - NF INTERNET'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 507'
###   @11=1774030440
###   @12=1775577522
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6828
###   @2=545
###   @3='PRO LABORE'
###   @4=333.96
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 545'
###   @11=1774030440
###   @12=1775874365
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6828
###   @2=545
###   @3='PRO LABORE'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 545'
###   @11=1774030440
###   @12=1775874365
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6829
###   @2=512
###   @3='Compra de produtos - Parcela 1/1 - NF PREVER'
###   @4=98.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 512'
###   @11=1774030440
###   @12=1775577534
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6829
###   @2=512
###   @3='Compra de produtos - Parcela 1/1 - NF PREVER'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 512'
###   @11=1774030440
###   @12=1775577534
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6830
###   @2=505
###   @3='Compra de produtos - Parcela 1/1 - NF RASTREADOR MOTO'
###   @4=59.90
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 505'
###   @11=1774030440
###   @12=1775577547
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6830
###   @2=505
###   @3='Compra de produtos - Parcela 1/1 - NF RASTREADOR MOTO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 505'
###   @11=1774030440
###   @12=1775577547
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6831
###   @2=508
###   @3='Compra de produtos - Parcela 1/1 - NF AGUA'
###   @4=196.56
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 508'
###   @11=1774030440
###   @12=1775577573
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6831
###   @2=508
###   @3='Compra de produtos - Parcela 1/1 - NF AGUA'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 508'
###   @11=1774030440
###   @12=1775577573
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6832
###   @2=443
###   @3='Compra de produtos - Parcela 1/1 - NF SEGURO DOS CARROS'
###   @4=430.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 443'
###   @11=1774030440
###   @12=1775577558
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6832
###   @2=443
###   @3='Compra de produtos - Parcela 1/1 - NF SEGURO DOS CARROS'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 443'
###   @11=1774030440
###   @12=1775577558
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6833
###   @2=506
###   @3='Compra de produtos - Parcela 1/1 - NF TELEFONE FIXO'
###   @4=49.90
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 506'
###   @11=1774030440
###   @12=1775577674
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6833
###   @2=506
###   @3='Compra de produtos - Parcela 1/1 - NF TELEFONE FIXO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:09'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 506'
###   @11=1774030440
###   @12=1775577674
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6834
###   @2=513
###   @3='Compra de produtos - Parcela 1/1 - NF'
###   @4=239.96
###   @5='2026:03:19'
###   @6='2026:04:10'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 513'
###   @11=1774030440
###   @12=1775577587
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6834
###   @2=513
###   @3='Compra de produtos - Parcela 1/1 - NF'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:10'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 513'
###   @11=1774030440
###   @12=1775577587
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6835
###   @2=432
###   @3='COPEL'
###   @4=1118.86
###   @5='2026:03:19'
###   @6='2026:04:12'
###   @7='2026:04:09'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 432'
###   @11=1774030440
###   @12=1775746751
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6835
###   @2=432
###   @3='COPEL'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:12'
###   @7='2026:04:09'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 432'
###   @11=1774030440
###   @12=1775746751
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6836
###   @2=527
###   @3='PRESTAÇÃO MOTO'
###   @4=585.00
###   @5='2026:03:19'
###   @6='2026:04:12'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 527'
###   @11=1774030440
###   @12=1775577602
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6836
###   @2=527
###   @3='PRESTAÇÃO MOTO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:12'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10='Importado da planilha. Código fornecedor: 527'
###   @11=1774030440
###   @12=1775577602
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=11.25
###   @5='2026:03:19'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270935
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6838
###   @2=565
###   @3='SIMPLES NACIONAL'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 565'
###   @11=1774030440
###   @12=1776270935
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6840
###   @2=409
###   @3='DIARISTA'
###   @4=120.00
###   @5='2026:03:19'
###   @6='2026:04:25'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 409'
###   @11=1774030440
###   @12=1775407466
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6840
###   @2=409
###   @3='DIARISTA'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:25'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 409'
###   @11=1774030440
###   @12=1775407466
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6842
###   @2=404
###   @3='Compra de produtos - Parcela 1/1 - NF KING HOST'
###   @4=98.99
###   @5='2026:03:19'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 404'
###   @11=1774030440
###   @12=1774030440
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6842
###   @2=404
###   @3='Compra de produtos - Parcela 1/1 - NF KING HOST'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 404'
###   @11=1774030440
###   @12=1774030440
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6868
###   @2=2
###   @3='PLENO COM DE GÁS 33 GAS'
###   @4=1200.00
###   @5='2026:03:21'
###   @6='2026:03:23'
###   @7='2026:03:23'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774111470
###   @12=1774303267
###   @13=10
###   @14=304
###   @15=1
###   @16=1
### SET
###   @1=6868
###   @2=2
###   @3='PLENO COM DE GÁS 33 GAS'
###   @4=30.00
###   @5='2026:03:21'
###   @6='2026:03:23'
###   @7='2026:03:23'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774111470
###   @12=1774303267
###   @13=10
###   @14=304
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=250.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776271002
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=30.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776271002
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6873
###   @2=431
###   @3='MARCIO ACOUGUE'
###   @4=135.00
###   @5='2026:03:21'
###   @6='2026:03:28'
###   @7='2026:03:28'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774116819
###   @12=1774705436
###   @13=1
###   @14=309
###   @15=1
###   @16=1
### SET
###   @1=6873
###   @2=431
###   @3='MARCIO ACOUGUE'
###   @4=30.00
###   @5='2026:03:21'
###   @6='2026:03:28'
###   @7='2026:03:28'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774116819
###   @12=1774705436
###   @13=1
###   @14=309
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6874
###   @2=428
###   @3='COMPRAS'
###   @4=51.00
###   @5='2026:03:22'
###   @6='2026:03:23'
###   @7='2026:03:22'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774186262
###   @12=1774186331
###   @13=1
###   @14=314
###   @15=1
###   @16=1
### SET
###   @1=6874
###   @2=428
###   @3='COMPRAS'
###   @4=30.00
###   @5='2026:03:22'
###   @6='2026:03:23'
###   @7='2026:03:22'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774186262
###   @12=1774186331
###   @13=1
###   @14=314
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6876
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF PLENO 33 GAS'
###   @4=1770.00
###   @5='2026:03:23'
###   @6='2026:03:24'
###   @7='2026:03:23'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774302840
###   @12=1774303206
###   @13=1
###   @14=317
###   @15=1
###   @16=1
### SET
###   @1=6876
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF PLENO 33 GAS'
###   @4=30.00
###   @5='2026:03:23'
###   @6='2026:03:24'
###   @7='2026:03:23'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774302840
###   @12=1774303206
###   @13=1
###   @14=317
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6877
###   @2=2
###   @3='NF 22 GAS 57.441'
###   @4=1980.00
###   @5='2026:03:23'
###   @6='2026:03:26'
###   @7='2026:03:26'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774272158
###   @12=1774539760
###   @13=3
###   @14=319
###   @15=1
###   @16=1
### SET
###   @1=6877
###   @2=2
###   @3='NF 22 GAS 57.441'
###   @4=30.00
###   @5='2026:03:23'
###   @6='2026:03:26'
###   @7='2026:03:26'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774272158
###   @12=1774539760
###   @13=3
###   @14=319
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6878
###   @2=548
###   @3='TILÁPIA - GRANDE'
###   @4=35.00
###   @5='2026:03:23'
###   @6='2026:03:27'
###   @7='2026:03:27'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774275050
###   @12=1774630861
###   @13=1
###   @14=320
###   @15=1
###   @16=1
### SET
###   @1=6878
###   @2=548
###   @3='TILÁPIA - GRANDE'
###   @4=30.00
###   @5='2026:03:23'
###   @6='2026:03:27'
###   @7='2026:03:27'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774275050
###   @12=1774630861
###   @13=1
###   @14=320
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6881
###   @2=2
###   @3='22 gás  NF. 57.474'
###   @4=1600.00
###   @5='2026:03:26'
###   @6='2026:04:01'
###   @7='2026:03:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774557706
###   @12=1774973750
###   @13=4
###   @14=333
###   @15=1
###   @16=1
### SET
###   @1=6881
###   @2=2
###   @3='22 gás  NF. 57.474'
###   @4=30.00
###   @5='2026:03:26'
###   @6='2026:04:01'
###   @7='2026:03:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774557706
###   @12=1774973750
###   @13=4
###   @14=333
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6882
###   @2=2
###   @3='22 gás'
###   @4=1400.00
###   @5='2026:03:27'
###   @6='2026:03:28'
###   @7='2026:03:28'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774631315
###   @12=1774706752
###   @13=1
###   @14=338
###   @15=1
###   @16=1
### SET
###   @1=6882
###   @2=2
###   @3='22 gás'
###   @4=30.00
###   @5='2026:03:27'
###   @6='2026:03:28'
###   @7='2026:03:28'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774631315
###   @12=1774706752
###   @13=1
###   @14=338
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6883
###   @2=548
###   @3='Compra de produtos - Parcela 1/7 - NF FEIJAO E BRASA'
###   @4=28.00
###   @5='2026:03:30'
###   @6='2026:03:31'
###   @7='2026:03:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774885258
###   @12=1774963636
###   @13=1
###   @14=348
###   @15=1
###   @16=1
### SET
###   @1=6883
###   @2=548
###   @3='Compra de produtos - Parcela 1/7 - NF FEIJAO E BRASA'
###   @4=30.00
###   @5='2026:03:30'
###   @6='2026:03:31'
###   @7='2026:03:31'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774885258
###   @12=1774963636
###   @13=1
###   @14=348
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6884
###   @2=548
###   @3='almoço dia 31/03 e 01/04'
###   @4=61.00
###   @5='2026:03:30'
###   @6='2026:04:01'
###   @7='2026:04:01'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774885258
###   @12=1775066217
###   @13=1
###   @14=348
###   @15=2
###   @16=1
### SET
###   @1=6884
###   @2=548
###   @3='almoço dia 31/03 e 01/04'
###   @4=30.00
###   @5='2026:03:30'
###   @6='2026:04:01'
###   @7='2026:04:01'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774885258
###   @12=1775066217
###   @13=1
###   @14=348
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6885
###   @2=548
###   @3='Compra de produtos - Parcela 3/7 - NF FEIJAO E BRASA'
###   @4=28.00
###   @5='2026:03:30'
###   @6='2026:04:02'
###   @7='2026:04:03'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774885258
###   @12=1775223184
###   @13=1
###   @14=348
###   @15=3
###   @16=1
### SET
###   @1=6885
###   @2=548
###   @3='Compra de produtos - Parcela 3/7 - NF FEIJAO E BRASA'
###   @4=30.00
###   @5='2026:03:30'
###   @6='2026:04:02'
###   @7='2026:04:03'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774885258
###   @12=1775223184
###   @13=1
###   @14=348
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6890
###   @2=2
###   @3='20 GAS'
###   @4=980.00
###   @5='2026:03:30'
###   @6='2026:04:03'
###   @7='2026:04:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774900773
###   @12=1775489575
###   @13=3
###   @14=349
###   @15=1
###   @16=1
### SET
###   @1=6890
###   @2=2
###   @3='20 GAS'
###   @4=30.00
###   @5='2026:03:30'
###   @6='2026:04:03'
###   @7='2026:04:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1774900773
###   @12=1775489575
###   @13=3
###   @14=349
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6891
###   @2=402
###   @3='Compra de produtos - Parcela 1/1 - NF'
###   @4=32.00
###   @5='2026:03:30'
###   @6='2026:03:31'
###   @7='2026:03:30'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774882559
###   @12=1774882606
###   @13=1
###   @14=351
###   @15=1
###   @16=1
### SET
###   @1=6891
###   @2=402
###   @3='Compra de produtos - Parcela 1/1 - NF'
###   @4=30.00
###   @5='2026:03:30'
###   @6='2026:03:31'
###   @7='2026:03:30'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1774882559
###   @12=1774882606
###   @13=1
###   @14=351
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6892
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF 22 GAS'
###   @4=1958.00
###   @5='2026:04:02'
###   @6='2026:04:07'
###   @7='2026:04:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775144151
###   @12=1775489588
###   @13=5
###   @14=364
###   @15=1
###   @16=1
### SET
###   @1=6892
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF 22 GAS'
###   @4=30.00
###   @5='2026:04:02'
###   @6='2026:04:07'
###   @7='2026:04:06'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775144151
###   @12=1775489588
###   @13=5
###   @14=364
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6894
###   @2=8
###   @3='Compra de produtos - Parcela 1/1 - NF JAPOSNESA'
###   @4=22.00
###   @5='2026:04:06'
###   @6='2026:04:07'
###   @7='2026:04:06'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1775486488
###   @12=1775486507
###   @13=1
###   @14=378
###   @15=1
###   @16=1
### SET
###   @1=6894
###   @2=8
###   @3='Compra de produtos - Parcela 1/1 - NF JAPOSNESA'
###   @4=30.00
###   @5='2026:04:06'
###   @6='2026:04:07'
###   @7='2026:04:06'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1775486488
###   @12=1775486507
###   @13=1
###   @14=378
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6895
###   @2=548
###   @3='Compra de produtos - Parcela 1/10 - NF ALMOÇO'
###   @4=24.00
###   @5='2026:04:07'
###   @6='2026:04:08'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775584675
###   @12=1775829522
###   @13=1
###   @14=386
###   @15=1
###   @16=1
### SET
###   @1=6895
###   @2=548
###   @3='Compra de produtos - Parcela 1/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:08'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775584675
###   @12=1775829522
###   @13=1
###   @14=386
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6896
###   @2=548
###   @3='Compra de produtos - Parcela 2/10 - NF ALMOÇO'
###   @4=26.00
###   @5='2026:04:07'
###   @6='2026:04:09'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775584675
###   @12=1775829509
###   @13=1
###   @14=386
###   @15=2
###   @16=1
### SET
###   @1=6896
###   @2=548
###   @3='Compra de produtos - Parcela 2/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:09'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775584675
###   @12=1775829509
###   @13=1
###   @14=386
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6897
###   @2=548
###   @3='Compra de produtos - Parcela 3/10 - NF ALMOÇO'
###   @4=24.00
###   @5='2026:04:07'
###   @6='2026:04:10'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775584675
###   @12=1775829496
###   @13=1
###   @14=386
###   @15=3
###   @16=1
### SET
###   @1=6897
###   @2=548
###   @3='Compra de produtos - Parcela 3/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:10'
###   @7='2026:04:10'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775584675
###   @12=1775829496
###   @13=1
###   @14=386
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6903
###   @2=548
###   @3='Compra de produtos - Parcela 9/10 - NF ALMOÇO'
###   @4=28.00
###   @5='2026:04:07'
###   @6='2026:04:16'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1775584675
###   @13=1
###   @14=386
###   @15=9
###   @16=1
### SET
###   @1=6903
###   @2=548
###   @3='Compra de produtos - Parcela 9/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:16'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1775584675
###   @13=1
###   @14=386
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6904
###   @2=548
###   @3='ALMOÇO - MEDIA'
###   @4=24.00
###   @5='2026:04:07'
###   @6='2026:04:07'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775584675
###   @12=1775584728
###   @13=1
###   @14=386
###   @15=10
###   @16=1
### SET
###   @1=6904
###   @2=548
###   @3='ALMOÇO - MEDIA'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:07'
###   @7='2026:04:07'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775584675
###   @12=1775584728
###   @13=1
###   @14=386
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6905
###   @2=2
###   @3='NF 22 gas 57613'
###   @4=1300.00
###   @5='2026:04:07'
###   @6='2026:04:10'
###   @7='2026:04:09'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1775593957
###   @12=1775746166
###   @13=3
###   @14=387
###   @15=1
###   @16=1
### SET
###   @1=6905
###   @2=2
###   @3='NF 22 gas 57613'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:10'
###   @7='2026:04:09'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1775593957
###   @12=1775746166
###   @13=3
###   @14=387
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6906
###   @2=500
###   @3='Compra de produtos - Parcela 1/1 - NF DESPESAS DIVERSAS'
###   @4=177.77
###   @5='2026:04:07'
###   @6='2026:04:06'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1775602162
###   @12=1775602203
###   @13=1
###   @14=388
###   @15=1
###   @16=1
### SET
###   @1=6906
###   @2=500
###   @3='Compra de produtos - Parcela 1/1 - NF DESPESAS DIVERSAS'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:06'
###   @7='2026:04:07'
###   @8=2
###   @9=4
###   @10=NULL
###   @11=1775602162
###   @12=1775602203
###   @13=1
###   @14=388
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6907
###   @2=2
###   @3='22 GAS NF. 57.634'
###   @4=1958.00
###   @5='2026:04:09'
###   @6='2026:04:13'
###   @7='2026:04:13'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775748565
###   @12=1776099783
###   @13=4
###   @14=394
###   @15=1
###   @16=1
### SET
###   @1=6907
###   @2=2
###   @3='22 GAS NF. 57.634'
###   @4=30.00
###   @5='2026:04:09'
###   @6='2026:04:13'
###   @7='2026:04:13'
###   @8=2
###   @9=2
###   @10=NULL
###   @11=1775748565
###   @12=1776099783
###   @13=4
###   @14=394
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6908
###   @2=402
###   @3='Compra de produtos - Parcela 1/1 - NF PADARIA MANA'
###   @4=42.40
###   @5='2026:04:11'
###   @6='2026:04:12'
###   @7='2026:04:11'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1775918770
###   @12=1775918804
###   @13=1
###   @14=401
###   @15=1
###   @16=1
### SET
###   @1=6908
###   @2=402
###   @3='Compra de produtos - Parcela 1/1 - NF PADARIA MANA'
###   @4=30.00
###   @5='2026:04:11'
###   @6='2026:04:12'
###   @7='2026:04:11'
###   @8=2
###   @9=1
###   @10=NULL
###   @11=1775918770
###   @12=1775918804
###   @13=1
###   @14=401
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6909
###   @2=2
###   @3='22 GAS'
###   @4=2112.00
###   @5='2026:04:11'
###   @6='2026:04:16'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775999256
###   @12=1776101626
###   @13=5
###   @14=402
###   @15=1
###   @16=1
### SET
###   @1=6909
###   @2=2
###   @3='22 GAS'
###   @4=30.00
###   @5='2026:04:11'
###   @6='2026:04:16'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775999256
###   @12=1776101626
###   @13=5
###   @14=402
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6911
###   @2=15
###   @3='Compra de produtos - Parcela 2/8 - NF COMPRAS'
###   @4=250.00
###   @5='2026:04:13'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099435
###   @13=3
###   @14=406
###   @15=2
###   @16=1
### SET
###   @1=6911
###   @2=15
###   @3='Compra de produtos - Parcela 2/8 - NF COMPRAS'
###   @4=30.00
###   @5='2026:04:13'
###   @6='2026:04:18'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099435
###   @13=3
###   @14=406
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6912
###   @2=15
###   @3='Compra de produtos - Parcela 3/8 - NF COMPRAS'
###   @4=250.00
###   @5='2026:04:13'
###   @6='2026:04:22'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099382
###   @13=3
###   @14=406
###   @15=3
###   @16=1
### SET
###   @1=6912
###   @2=15
###   @3='Compra de produtos - Parcela 3/8 - NF COMPRAS'
###   @4=30.00
###   @5='2026:04:13'
###   @6='2026:04:22'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099382
###   @13=3
###   @14=406
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6913
###   @2=15
###   @3='Compra de produtos - Parcela 4/8 - NF COMPRAS'
###   @4=250.00
###   @5='2026:04:13'
###   @6='2026:04:25'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099382
###   @13=3
###   @14=406
###   @15=4
###   @16=1
### SET
###   @1=6913
###   @2=15
###   @3='Compra de produtos - Parcela 4/8 - NF COMPRAS'
###   @4=30.00
###   @5='2026:04:13'
###   @6='2026:04:25'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099382
###   @13=3
###   @14=406
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6914
###   @2=15
###   @3='Compra de produtos - Parcela 5/8 - NF COMPRAS'
###   @4=250.00
###   @5='2026:04:13'
###   @6='2026:04:28'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099382
###   @13=3
###   @14=406
###   @15=5
###   @16=1
### SET
###   @1=6914
###   @2=15
###   @3='Compra de produtos - Parcela 5/8 - NF COMPRAS'
###   @4=30.00
###   @5='2026:04:13'
###   @6='2026:04:28'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099382
###   @13=3
###   @14=406
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6915
###   @2=15
###   @3='Compra de produtos - Parcela 6/8 - NF COMPRAS'
###   @4=250.00
###   @5='2026:04:13'
###   @6='2026:05:02'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099465
###   @13=3
###   @14=406
###   @15=6
###   @16=1
### SET
###   @1=6915
###   @2=15
###   @3='Compra de produtos - Parcela 6/8 - NF COMPRAS'
###   @4=30.00
###   @5='2026:04:13'
###   @6='2026:05:02'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099465
###   @13=3
###   @14=406
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6916
###   @2=15
###   @3='Compra de produtos - Parcela 7/8 - NF COMPRAS'
###   @4=250.00
###   @5='2026:04:13'
###   @6='2026:05:05'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099498
###   @13=3
###   @14=406
###   @15=7
###   @16=1
### SET
###   @1=6916
###   @2=15
###   @3='Compra de produtos - Parcela 7/8 - NF COMPRAS'
###   @4=30.00
###   @5='2026:04:13'
###   @6='2026:05:05'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099498
###   @13=3
###   @14=406
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6917
###   @2=15
###   @3='Compra de produtos - Parcela 8/8 - NF COMPRAS'
###   @4=250.00
###   @5='2026:04:13'
###   @6='2026:05:09'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099507
###   @13=3
###   @14=406
###   @15=8
###   @16=1
### SET
###   @1=6917
###   @2=15
###   @3='Compra de produtos - Parcela 8/8 - NF COMPRAS'
###   @4=30.00
###   @5='2026:04:13'
###   @6='2026:05:09'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776099382
###   @12=1776099507
###   @13=3
###   @14=406
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6918
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF 22 GÁS NF. 57.740'
###   @4=2112.00
###   @5='2026:04:15'
###   @6='2026:04:20'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776266264
###   @12=1776266264
###   @13=5
###   @14=415
###   @15=1
###   @16=1
### SET
###   @1=6918
###   @2=2
###   @3='Compra de produtos - Parcela 1/1 - NF 22 GÁS NF. 57.740'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:04:20'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1776266264
###   @12=1776266264
###   @13=5
###   @14=415
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6919
###   @2=566
###   @3='Compra de produtos - Parcela 1/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=1
###   @16=1
### SET
###   @1=6919
###   @2=566
###   @3='Compra de produtos - Parcela 1/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6920
###   @2=566
###   @3='Compra de produtos - Parcela 2/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=2
###   @16=1
### SET
###   @1=6920
###   @2=566
###   @3='Compra de produtos - Parcela 2/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6921
###   @2=566
###   @3='Compra de produtos - Parcela 3/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=3
###   @16=1
### SET
###   @1=6921
###   @2=566
###   @3='Compra de produtos - Parcela 3/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6922
###   @2=566
###   @3='Compra de produtos - Parcela 4/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=4
###   @16=1
### SET
###   @1=6922
###   @2=566
###   @3='Compra de produtos - Parcela 4/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6923
###   @2=566
###   @3='Compra de produtos - Parcela 5/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=5
###   @16=1
### SET
###   @1=6923
###   @2=566
###   @3='Compra de produtos - Parcela 5/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6924
###   @2=566
###   @3='Compra de produtos - Parcela 6/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=6
###   @16=1
### SET
###   @1=6924
###   @2=566
###   @3='Compra de produtos - Parcela 6/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6925
###   @2=566
###   @3='Compra de produtos - Parcela 7/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=7
###   @16=1
### SET
###   @1=6925
###   @2=566
###   @3='Compra de produtos - Parcela 7/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6926
###   @2=566
###   @3='Compra de produtos - Parcela 8/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=8
###   @16=1
### SET
###   @1=6926
###   @2=566
###   @3='Compra de produtos - Parcela 8/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6927
###   @2=566
###   @3='Compra de produtos - Parcela 9/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=9
###   @16=1
### SET
###   @1=6927
###   @2=566
###   @3='Compra de produtos - Parcela 9/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6928
###   @2=566
###   @3='Compra de produtos - Parcela 10/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=10
###   @16=1
### SET
###   @1=6928
###   @2=566
###   @3='Compra de produtos - Parcela 10/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6929
###   @2=566
###   @3='Compra de produtos - Parcela 11/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2027:03:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=11
###   @16=1
### SET
###   @1=6929
###   @2=566
###   @3='Compra de produtos - Parcela 11/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2027:03:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=11
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6930
###   @2=566
###   @3='Compra de produtos - Parcela 12/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=60.00
###   @5='2026:04:15'
###   @6='2027:04:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=12
###   @16=1
### SET
###   @1=6930
###   @2=566
###   @3='Compra de produtos - Parcela 12/12 - NF PATROCÍNIO DO MARIGÁS'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2027:04:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270097
###   @12=1776270097
###   @13=30
###   @14=416
###   @15=12
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6931
###   @2=424
###   @3='Compra de produtos - Parcela 1/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=1
###   @16=1
### SET
###   @1=6931
###   @2=424
###   @3='Compra de produtos - Parcela 1/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6932
###   @2=424
###   @3='Compra de produtos - Parcela 2/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=2
###   @16=1
### SET
###   @1=6932
###   @2=424
###   @3='Compra de produtos - Parcela 2/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6933
###   @2=424
###   @3='Compra de produtos - Parcela 3/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=3
###   @16=1
### SET
###   @1=6933
###   @2=424
###   @3='Compra de produtos - Parcela 3/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6934
###   @2=424
###   @3='Compra de produtos - Parcela 4/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=4
###   @16=1
### SET
###   @1=6934
###   @2=424
###   @3='Compra de produtos - Parcela 4/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6935
###   @2=424
###   @3='Compra de produtos - Parcela 5/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=5
###   @16=1
### SET
###   @1=6935
###   @2=424
###   @3='Compra de produtos - Parcela 5/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6936
###   @2=424
###   @3='Compra de produtos - Parcela 6/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=6
###   @16=1
### SET
###   @1=6936
###   @2=424
###   @3='Compra de produtos - Parcela 6/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6937
###   @2=424
###   @3='Compra de produtos - Parcela 7/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=7
###   @16=1
### SET
###   @1=6937
###   @2=424
###   @3='Compra de produtos - Parcela 7/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6938
###   @2=424
###   @3='Compra de produtos - Parcela 8/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=8
###   @16=1
### SET
###   @1=6938
###   @2=424
###   @3='Compra de produtos - Parcela 8/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6939
###   @2=424
###   @3='Compra de produtos - Parcela 9/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=9
###   @16=1
### SET
###   @1=6939
###   @2=424
###   @3='Compra de produtos - Parcela 9/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6940
###   @2=424
###   @3='Compra de produtos - Parcela 10/10 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=10
###   @16=1
### SET
###   @1=6940
###   @2=424
###   @3='Compra de produtos - Parcela 10/10 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270754
###   @12=1776270754
###   @13=30
###   @14=418
###   @15=10
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6941
###   @2=424
###   @3='Compra de produtos - Parcela 1/1 - NF VIVO TELEFONIA'
###   @4=70.00
###   @5='2026:04:15'
###   @6='2026:04:25'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270825
###   @12=1776270825
###   @13=10
###   @14=419
###   @15=1
###   @16=1
### SET
###   @1=6941
###   @2=424
###   @3='Compra de produtos - Parcela 1/1 - NF VIVO TELEFONIA'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:04:25'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270825
###   @12=1776270825
###   @13=10
###   @14=419
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6942
###   @2=565
###   @3='Compra de produtos - Parcela 1/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=1
###   @16=1
### SET
###   @1=6942
###   @2=565
###   @3='Compra de produtos - Parcela 1/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:05:15'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6943
###   @2=565
###   @3='Compra de produtos - Parcela 2/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=2
###   @16=1
### SET
###   @1=6943
###   @2=565
###   @3='Compra de produtos - Parcela 2/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:06:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=2
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6944
###   @2=565
###   @3='Compra de produtos - Parcela 3/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=3
###   @16=1
### SET
###   @1=6944
###   @2=565
###   @3='Compra de produtos - Parcela 3/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:07:14'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=3
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6945
###   @2=565
###   @3='Compra de produtos - Parcela 4/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=4
###   @16=1
### SET
###   @1=6945
###   @2=565
###   @3='Compra de produtos - Parcela 4/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:08:13'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6946
###   @2=565
###   @3='Compra de produtos - Parcela 5/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=5
###   @16=1
### SET
###   @1=6946
###   @2=565
###   @3='Compra de produtos - Parcela 5/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:09:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6947
###   @2=565
###   @3='Compra de produtos - Parcela 6/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=6
###   @16=1
### SET
###   @1=6947
###   @2=565
###   @3='Compra de produtos - Parcela 6/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:10:12'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6948
###   @2=565
###   @3='Compra de produtos - Parcela 7/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=7
###   @16=1
### SET
###   @1=6948
###   @2=565
###   @3='Compra de produtos - Parcela 7/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:11:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=7
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6949
###   @2=565
###   @3='Compra de produtos - Parcela 8/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=8
###   @16=1
### SET
###   @1=6949
###   @2=565
###   @3='Compra de produtos - Parcela 8/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2026:12:11'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=8
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6950
###   @2=565
###   @3='Compra de produtos - Parcela 9/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=9
###   @16=1
### SET
###   @1=6950
###   @2=565
###   @3='Compra de produtos - Parcela 9/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2027:01:10'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=9
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6951
###   @2=565
###   @3='Compra de produtos - Parcela 10/10 - NF SIMPLES'
###   @4=3.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=10
###   @16=1
### SET
###   @1=6951
###   @2=565
###   @3='Compra de produtos - Parcela 10/10 - NF SIMPLES'
###   @4=30.00
###   @5='2026:04:15'
###   @6='2027:02:09'
###   @7=NULL
###   @8=1
###   @9=3
###   @10=NULL
###   @11=1776270990
###   @12=1776270990
###   @13=30
###   @14=420
###   @15=10
###   @16=1
# at 172214
#260415 10:44:28 server id 1  end_log_pos 172245 CRC32 0x8a97c0ab 	Xid = 17737
COMMIT/*!*/;
# at 172245
#260415 10:45:01 server id 1  end_log_pos 172324 CRC32 0xb4429b3b 	Anonymous_GTID	last_committed=92	sequence_number=93	rbr_only=yes	original_committed_timestamp=1776260701812595	immediate_commit_timestamp=1776260701812595	transaction_length=1550
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260701812595 (2026-04-15 10:45:01.812595 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260701812595 (2026-04-15 10:45:01.812595 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260701812595*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 172324
#260415 10:45:01 server id 1  end_log_pos 172419 CRC32 0xb0c25c37 	Query	thread_id=454	exec_time=0	error_code=0
SET TIMESTAMP=1776260701/*!*/;
/*!\C utf8mb4 *//*!*/;
SET @@session.character_set_client=224,@@session.collation_connection=224,@@session.collation_server=255/*!*/;
BEGIN
/*!*/;
# at 172419
#260415 10:45:01 server id 1  end_log_pos 172510 CRC32 0xb938a117 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 172510
#260415 10:45:01 server id 1  end_log_pos 173764 CRC32 0xe6767955 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776271002
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776271501
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=30.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776271002
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=30.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776271501
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 173764
#260415 10:45:01 server id 1  end_log_pos 173795 CRC32 0x8deaf870 	Xid = 17741
COMMIT/*!*/;
# at 173795
#260415 10:45:01 server id 1  end_log_pos 173874 CRC32 0xa97bac11 	Anonymous_GTID	last_committed=93	sequence_number=94	rbr_only=yes	original_committed_timestamp=1776260701815084	immediate_commit_timestamp=1776260701815084	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260701815084 (2026-04-15 10:45:01.815084 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260701815084 (2026-04-15 10:45:01.815084 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260701815084*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 173874
#260415 10:45:01 server id 1  end_log_pos 173969 CRC32 0xa3cde8ba 	Query	thread_id=454	exec_time=0	error_code=0
SET TIMESTAMP=1776260701/*!*/;
BEGIN
/*!*/;
# at 173969
#260415 10:45:01 server id 1  end_log_pos 174060 CRC32 0xdb07c98e 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 174060
#260415 10:45:01 server id 1  end_log_pos 174554 CRC32 0x0942f5eb 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271002
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 174554
#260415 10:45:01 server id 1  end_log_pos 174585 CRC32 0xf9a1ef48 	Xid = 17744
COMMIT/*!*/;
# at 174585
#260415 10:45:09 server id 1  end_log_pos 174664 CRC32 0x36e269fa 	Anonymous_GTID	last_committed=94	sequence_number=95	rbr_only=yes	original_committed_timestamp=1776260709352964	immediate_commit_timestamp=1776260709352964	transaction_length=1550
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260709352964 (2026-04-15 10:45:09.352964 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260709352964 (2026-04-15 10:45:09.352964 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260709352964*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 174664
#260415 10:45:09 server id 1  end_log_pos 174759 CRC32 0xab503755 	Query	thread_id=455	exec_time=0	error_code=0
SET TIMESTAMP=1776260709/*!*/;
BEGIN
/*!*/;
# at 174759
#260415 10:45:09 server id 1  end_log_pos 174850 CRC32 0xf38336e4 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 174850
#260415 10:45:09 server id 1  end_log_pos 176104 CRC32 0x22ba739d 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776271501
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### SET
###   @1=6820
###   @2=519
###   @3='Compra de produtos - NF TROCA DE OLEO DA MOTO'
###   @4=30.00
###   @5='2026:03:19'
###   @6='2026:03:27'
###   @7=NULL
###   @8=3
###   @9=5
###   @10='Importado da planilha. Código fornecedor: 519'
###   @11=1774030440
###   @12=1776271509
###   @13=1
###   @14=NULL
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=30.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776271501
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### SET
###   @1=6872
###   @2=14
###   @3='Compra de produtos - Parcela 1/1 - NF COMPRAS'
###   @4=30.00
###   @5='2026:03:21'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1774116777
###   @12=1776271509
###   @13=10
###   @14=308
###   @15=1
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### SET
###   @1=6898
###   @2=548
###   @3='Compra de produtos - Parcela 4/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271509
###   @13=1
###   @14=386
###   @15=4
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### SET
###   @1=6900
###   @2=548
###   @3='Compra de produtos - Parcela 6/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:13'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271509
###   @13=1
###   @14=386
###   @15=6
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=7
###   @16=1
### SET
###   @1=6901
###   @2=548
###   @3='Compra de produtos - Parcela 7/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:14'
###   @7=NULL
###   @8=3
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271509
###   @13=1
###   @14=386
###   @15=7
###   @16=1
# at 176104
#260415 10:45:09 server id 1  end_log_pos 176135 CRC32 0x2787342d 	Xid = 17822
COMMIT/*!*/;
# at 176135
#260415 10:45:09 server id 1  end_log_pos 176214 CRC32 0xae16a1d7 	Anonymous_GTID	last_committed=95	sequence_number=96	rbr_only=yes	original_committed_timestamp=1776260709355760	immediate_commit_timestamp=1776260709355760	transaction_length=790
/*!50718 SET TRANSACTION ISOLATION LEVEL READ COMMITTED*//*!*/;
# original_commit_timestamp=1776260709355760 (2026-04-15 10:45:09.355760 Hora oficial do Brasil)
# immediate_commit_timestamp=1776260709355760 (2026-04-15 10:45:09.355760 Hora oficial do Brasil)
/*!80001 SET @@session.original_commit_timestamp=1776260709355760*//*!*/;
/*!80014 SET @@session.original_server_version=80407*//*!*/;
/*!80014 SET @@session.immediate_server_version=80407*//*!*/;
SET @@SESSION.GTID_NEXT= 'ANONYMOUS'/*!*/;
# at 176214
#260415 10:45:09 server id 1  end_log_pos 176309 CRC32 0x1821ddcc 	Query	thread_id=455	exec_time=0	error_code=0
SET TIMESTAMP=1776260709/*!*/;
BEGIN
/*!*/;
# at 176309
#260415 10:45:09 server id 1  end_log_pos 176400 CRC32 0xd268662b 	Table_map: `marigas`.`contas_a_pagar` mapped to number 90
# has_generated_invisible_primary_key=0
# at 176400
#260415 10:45:09 server id 1  end_log_pos 176894 CRC32 0xf37ae4dc 	Update_rows: table id 90 flags: STMT_END_F
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### SET
###   @1=6899
###   @2=548
###   @3='Compra de produtos - Parcela 5/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271509
###   @13=1
###   @14=386
###   @15=5
###   @16=1
### UPDATE `marigas`.`contas_a_pagar`
### WHERE
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271501
###   @13=1
###   @14=386
###   @15=8
###   @16=1
### SET
###   @1=6902
###   @2=548
###   @3='Compra de produtos - Parcela 8/10 - NF ALMOÇO'
###   @4=30.00
###   @5='2026:04:07'
###   @6='2026:04:15'
###   @7=NULL
###   @8=1
###   @9=5
###   @10=NULL
###   @11=1775584675
###   @12=1776271509
###   @13=1
###   @14=386
###   @15=8
###   @16=1
# at 176894
#260415 10:45:09 server id 1  end_log_pos 176925 CRC32 0x7225ffc5 	Xid = 17825
COMMIT/*!*/;
SET @@SESSION.GTID_NEXT= 'AUTOMATIC' /* added by mysqlbinlog */ /*!*/;
DELIMITER ;
# End of log file
/*!50003 SET COMPLETION_TYPE=@OLD_COMPLETION_TYPE*/;
/*!50530 SET @@SESSION.PSEUDO_SLAVE_MODE=0*/;
