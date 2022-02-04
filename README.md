See https://github.com/MatejKucera/ccl


# Custom Client Launcher - serverside

## Non-docker deployment

For non-docker deployment, follow these steps:

1. Clone the repository
2. Create two directories, `source` and `public`
3. Make directory `public` publicly accessible via HTTP
4. Make sure that directory `source` **is not** publicly accessible
5. Rename `.env.example` to `.env` and update it with full path of `source` and `public` directories, ignore the "docker only" part of the `.env` file
6. Rename `config.xml.example` to `config.xml` and copy it to the `public` directory
7. Update `config.xml`, see below
8. Upload/copy patches to the `source` directory.
9. Navigate to the root directory of the project (where `deploy.php` is) and run the following script for all patches present in the `source` directory: `php deploy.php [patchname]`, eg. `php deploy.php patch-X.MPQ`


## config.xml 
 
```xml
<?xml version="1.0" encoding="utf-8"?>
<source>

    <server>
        <title>Example RP</title>                   <!-- Server title -->
        <realmlist>example.com:8891</realmlist>     <!-- Realmlist -->
        <web>https://example.com</web>              <!-- Web homepage of the server -->
        <help>https://example.com/launcher</help>  <!-- Where players can get more information about the launcher and some support -->
        <guid>example.com</guid>                   <!-- Unique identifier of the server, usually domain -->
    </server>

    <!-- Two values, available of maintenance. If in maintenance mode, client will not download patches 
            Is set automatically via deploy.php -->
    <mode>available</mode> 

    <launcher>
        <currentVersion>3</currentVersion>                              <!-- Current version of launcher -->
        <url>https://launcher.example.com/CustomClientLauncher.exe</url>  <!-- Publicly accessible launcher file -->
        <allowUpdate>true</allowUpdate>                                  <!-- Update launcher automatically (WARNING - alpha functionality) -->
	    <exe>CustomClientLauncher.exe</exe>                             <!-- Name of the exe file -->
    </launcher>

    <patches>
        <patch>
            <file>patch-A.MPQ</file>                                 <!-- Title of patch -->
            <url>https://launcher.example.com/patch-A.MPQ</url>      <!-- Link to publicly accessible patch file -->
            <md5>6ad8184077b20b8d85b9a77e995bd590</md5>              <!-- Checksum of current version of the file (will be set automatically) -->
            <optional>false</optional>                               <!-- True if the patch is optional, false it not -->
        </patch>
        <patch>
            <file>patch-B.MPQ</file>                                 <!-- Title of patch -->
            <url>https://launcher.example.com/patch-B.MPQ</url>      <!-- Link to publicly accessible patch file -->
            <md5>8e1c8289d286c7612e6464922c978c28</md5>              <!-- Checksum of current version of the file (will be set automatically) -->
            <optional>false</optional>                               <!-- True if the patch is optional, false it not -->
        </patch>
    </patches>

    <!-- Date of last changes to this file (will be set automatically) -->
    <lastUpdate>2022-01-12T19:48:45+0000</lastUpdate>


</source>
```


Notice: Patch names (eg patch-X.MPQ) **are** case sensitive. Remain consistent with letter case.