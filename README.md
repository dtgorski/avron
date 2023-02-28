# avron

Apache Avro IDL transpiler.

### THIS CODE IS IN ALPHA STATE - WORK IN PROGRESS

---

Transform matrix:

|   ┌─➤    | AVDL | AVSC | AVPR | PHP |
|:--------:|:----:|:----:|:----:|:---:|
| **AVDL** |  ✔   |      |      |     |
| **AVSC** |      |      |      |     |
| **AVPR** |      |      |      |     |


### @dev

Try ```make```:

```
$ make

 make help           Displays this list
 make clean          Removes generated files
 make dist-clean     Removes generated files and ./vendor
 make install        Installs ./vendor dependencies
 make update         Updates ./vendor dependencies
 make test           Executes unit tests
 make bench          Runs benchmarks
 make sniff          Runs linter on source and tests
 make sniff-fix      Tries to fix linter complaints
 make analyse        Performs static analysis


 Usage: make <TARGET> [ARGS=...]
```

### Disclaimer
The implementation and features of ```avron``` follow the [YAGNI](https://en.wikipedia.org/wiki/You_aren%27t_gonna_need_it) principle.
There is no claim for completeness or reliability.

### License
[MIT](https://opensource.org/licenses/MIT) - © dtg [at] lengo [dot] org
