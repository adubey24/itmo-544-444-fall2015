#!/bin/bash

aws rds create-db-instance-read-replica --db-instance-identifier addbreplica --source-db-instance-identifier ad-db-mp
