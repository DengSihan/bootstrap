#!/bin/bash
sudo systemctl restart elasticsearch.service
curl http://127.0.0.1:9200/
