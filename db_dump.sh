#!/bin/bash
FROM=RAMTEST
TO=$(date +"%Y-%m-%d")
printf "Dumping $FROM to $FROM.dump.$TO.sql\n\n"
pg_dump -Fc --exclude-table-data "\"Audit Trail\"" --exclude-table-data "\"Assy Job Ticket AT\"" -Upostgres $FROM > $FROM.dump.$TO.sql
FROM=RAM
printf "Dumping $FROM to $FROM.dump.$TO.sql\n\n"
pg_dump -Fc --exclude-table-data "\"Audit Trail\"" --exclude-table-data "\"Assy Job Ticket AT\"" -Upostgres $FROM > $FROM.dump.$TO.sql
printf "Dropping DB RAMTEST\n"
dropdb -Upostgres RAMTEST
printf "DB Dropped\n"
printf "Creating DB RAMTEST\n"
createdb -Upostgres RAMTEST
printf "DB Created\n"
printf "Restoring DB RAMTEST\n"
pg_restore -Upostgres -dRAMTEST < $FROM.dump.$TO.sql
#pg_restore -Upostgres -dRAMTEST < RAM.dump.2019-10-08.sql
printf "Done\n"
