### Hexlet tests and linter status:
[![Actions Status](https://github.com/Ekweenox49/php-project-lvl2/workflows/hexlet-check/badge.svg)](https://github.com/Ekweenox49/php-project-lvl2/actions)
<a href="https://codeclimate.com/github/Ekweenox49/php-project-lvl2/maintainability"><img src="https://api.codeclimate.com/v1/badges/5ef1b99eb1fa4d881ca4/maintainability" /></a>
[![Lint](https://github.com/Ekweenox49/php-project-lvl2/actions/workflows/lint.yml/badge.svg?branch=main)](https://github.com/Ekweenox49/php-project-lvl2/actions/workflows/lint.yml)
<a href="https://codeclimate.com/github/Ekweenox49/php-project-lvl2/test_coverage"><img src="https://api.codeclimate.com/v1/badges/5ef1b99eb1fa4d881ca4/test_coverage" /></a>

### Difference Calculator
A difference calculator is a program determines the difference between two data structures. It can be used as ready-made solution for tracking changes in tree-structured configuration files.

Utility features:

-   Supports two input formats: yaml and json
-   Three output formats: plain, stylish and json

### Requirements
-   PHP 8
-   Composer 2.3

### Install
```sh
$ git clone https://github.com/Ekweenox49/php-project-lvl2.git

$ make install
```

### Asciinema
#### Two plane yaml files (default stylish output format)
```sh
$ gendiff /pathToFile/firstFile.yaml /pathToFile/secondFile.yaml
```
<a href="https://asciinema.org/a/pafju3qvmnEbgM3T8ah7Oa62M" target="_blank"><img src="https://asciinema.org/a/pafju3qvmnEbgM3T8ah7Oa62M.svg" /></a>

#### Two tree-structured json files (default stylish output format)
```sh
$ gendiff /pathToFile/firstTree.json /pathToFile/secondTree.json
```
<a href="https://asciinema.org/a/BpCBkAIERkLhoZAp5dksXEvHW" target="_blank"><img src="https://asciinema.org/a/BpCBkAIERkLhoZAp5dksXEvHW.svg" /></a>

#### Two tree-structured json files (json output format)
```sh
$ gendiff --format json /pathToFile/firstTree.json /pathToFile/secondTree.json
```
<a href="https://asciinema.org/a/w8AYV5tUcP2VQp04ZKuq4X9da" target="_blank"><img src="https://asciinema.org/a/w8AYV5tUcP2VQp04ZKuq4X9da.svg" /></a>

#### Two tree-structured json files (plain output format)
```sh
$ gendiff --format plain /pathToFile/firstTree.json /pathToFile/secondTree.json
```
<a href="https://asciinema.org/a/uu3BOR9MA8BsTn6v3HR9kZ7mC" target="_blank"><img src="https://asciinema.org/a/uu3BOR9MA8BsTn6v3HR9kZ7mC.svg" /></a>
