# Requirements

-   PHP ^8.1

# Installation

1. Clone the repository
    ```bash
    git clone https://github.com/h3mantD/forest.git
    ```
2. Copy build file into /usr/bin
    ```bash
    sudo cp forest/builds/forest /usr/bin/forest
    ```

# Command Details

```bash
Description:
  Create forest

Usage:
  make [options]

Options:
  -w, --where[=WHERE]   Destination where to create desired directory structure [default: "./"]
  -f, --from[=FROM]     Directory structures file path (create directory structure using `tree -J` command) [default: "./"]
      --s[=S]           Structure
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```
