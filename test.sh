#!/bin/bash

./cleanup.sh

#declare an array in bash
declare -a instanceARR

mapfile -t instanceARR < <(aws ec2 run-instances --image-id ami-d05e75b8 --count $1 --instance-type t2.micro --key-name itmo544-virtualbox --security-group-ids sg-aea298c9 --subnet-id subnet-3bf8a910 --associate-public-ip-address --iam-instance-profile Name=phpdeveloper --user-data file://../itmo-544-444-env/install-webserver.sh --output table | grep InstanceId | sed "s/|//g" | tr -d ' ' | sed "s/InstanceId//g")

echo ${instanceARR[@]}

aws ec2 wait instance-running --instance-ids ${instanceARR[@]}
echo "instances are running"


ELBURL=(`aws elb create-load-balancer --load-balancer-name $2 --listeners Protocol=HTTP,LoadBalancerPort=80,InstanceProtocol=HTTP,InstancePort=80 --subnets subnet-3bf8a910 --security-groups sg-aea298c9 --output=text`); echo $ELBURL

echo -e "\nFinished launching ELB and sleeping 25 seconds"
for i in {0..25}; do echo -ne '.'; sleep 1;done
echo "\n"

aws elb register-instances-with-load-balancer --load-balancer-name $2 --instances ${instanceARR[@]}

aws elb configure-health-check --load-balancer-name $2 --health-check Target=HTTP:80/index.html,Interval=30,UnhealthyThreshold=2,HealthyThreshold=2,Timeout=3 

echo -e "\nwaiting an additional 3 minutes(180 seconds) - before opening the ELB in a webbrowser"
for i in {0..60}; do echo -ne '.'; sleep 1;done

#create launch configuration

aws autoscaling create-launch-configuration --launch-configuration-name itmo544ad-launch-config --image-id ami-d05e75b8 --key-name itmo544-virtualbox --security-groups sg-aea298c9 --instance-type t2.micro --user-data file://../itmo-544-444-env/install-webserver.sh --iam-instance-profile phpdeveloper

#create an autoscaling group

aws autoscaling create-auto-scaling-group --auto-scaling-group-name itmo-544-extended-auto-scaling-group-2 --launch-configuration-name itmo544ad-launch-config --load-balancer-names $2  --health-check-type ELB --min-size 3 --max-size 6 --desired-capacity 3 --default-cooldown 600 --health-check-grace-period 120 --vpc-zone-identifier subnet-3bf8a910

#command to create subnet group

aws rds create-db-subnet-group --db-subnet-group-name mp1 --db-subnet-group-description "group for mp1" --subnet-ids subnet-8759a3ba subnet-3bf8a910


aws rds create-db-instance --db-instance-identifier ad-db --db-instance-class db.t1.micro --engine MySQL --master-username controller --master-user-password anvi2416 --allocated-storage 5 --db-subnet-group-name mp1 --db-name customerrecords

aws rds wait db-instance-available --db-instance-identifier ad-db

#creating sns-topic 

ARN=(`aws sns create-topic --name ad-cloud-watch`)

echo "This is the ARN : $ARN"

aws sns set-topic-attributes --topic-arn $ARN --attribute-name DisplayName --attribute-value cloud-watch
aws sns subscribe --topic-arn $ARN --protocol email --notification-endpoint adubey4@hawk.iit.edu

# creating cloud watch metrics

aws cloudwatch put-metric-alarm --alarm-name ad-cloud-watch --alarm-description "Alarm when CPU exceeds 30" --metric-name Latency --namespace AWS/ELB --statistic Maximum --period 60 --threshold 30 --comparison-operator GreaterThanOrEqualToThreshold  --dimensions Name=LoadBalancerName,Value=$2 --evaluation-periods 6 --alarm-actions $ARN --unit Milliseconds

echo "Created Cloud watch metrics"


#last step
#firefox SELBURL &
export ELBURL

































