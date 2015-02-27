#!/bin/bash
coffee --watch --compile static/js/*.coffee&
coffee --watch --compile static/js/supervisor/*.coffee&
jade -w -P application/views/*.jade&

echo "The development environment has ready!"
