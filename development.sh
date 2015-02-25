#!/bin/bash
coffee --watch --compile static/js/*.coffee&
jade -w -P application/views/*.jade&

echo "The development environment has ready!"
