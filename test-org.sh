#!/bin/bash

aws ec2 run-instances --image-id ami-d05e75b8 --count $1 --instance-type t2.micro --key-name itmo544-virtualbox --security-group-ids sg-aea298c9 --subnet-id subnet-3bf8a910 --associate-public-ip-address --user-data file://../itmo-544-444-env/install-webserver.sh

#command to create subnet group

aws rds create-db-subnet-group --db-subnet-group-name mp1 --db-subnet-group-description "group for mp1" --subnet-ids subnet-8759a3ba subnet-3bf8a910


aws rds create-db-instance --db-instance-identifier ad-db --db-instance-class db.t1.micro --engine MySQL --master-username controller --master-user-password anvi2416 --allocated-storage 5 --db-subnet-group-name mp1

aws rds wait db-instance-available --db-instance-identifier ad-db
