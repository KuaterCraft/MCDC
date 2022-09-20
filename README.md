<img src="https://i.imgur.com/MxTeS95h.jpg" width="30%">

# MCDC
[![License](https://img.shields.io/github/license/KuaterCraft/MCDC?color=green&label=License)](https://github.com/KuaterCraft/MCDC/blob/main/LICENSE)
[![](https://poggit.pmmp.io/shield.state/MCDC)](https://poggit.pmmp.io/p/MCDC)
[![Version](https://img.shields.io/github/v/release/KuaterCraft/MCDC)](https://github.com/KuaterCraft/MCDC/releases/latest)
[![Discord](https://img.shields.io/discord/923478312830001162?label=Discord)](https://discord.gg/zQ3SQ4zzN5)
* Point to be noted:- Large commands output will not show !! example: having 20+ plugin and doing /? or /help output will not show


### Send console logs to your discord using webhook

* Outputs player chat and commands to a Discord channel

## How to start

1. Download the latest release and place it in your plugins folder
2. Restart your server.
3. Go to plugin data folder
4. Open your Discord server
5. Create a channel where the logs should be send
6. Go to server settings -> integrations -> webhook -> create one for logs -> redirect the webhook to the log channel
7. Copy the webhook url
8. Go to the MCDC config.yml
9. paste it in the discord_webhook_url ""
10. Restart Your server

You should now see your server console logs

## Getting help

Need help? join our [Discord](https://discord.gg/zQ3SQ4zzN5)

## Detailed configuration

* enabled: true # Did you enabled me?
* discord_webhook_url: "" # Put that bad boy token here xd
* discord_webhook_name: "MCDC" # What should be the custom name for the bad boi
* discord_webhook_override: false # Should this override badboy? (Defualt will be false) 
* discord_webhook_refresh: 10 #Delay in updating discord
* send_console: true #Send console logs?
* show_player_events: true #Tell when a player joins/leaves the server
* enable_pings: true #Honor pinging from Minecraft chat in discord
* discord_webhook_title: "" #Title for the badboy
* discord_webhook_description: "" #Description? for this badboy [optional]
* discord_webhook_color: "" #Say the embed color in hex code ex:- #ff0000 [optional]
* discord_webhook_footer: "" # What should be the footerjQuery32107105660293243186_1663501933827? [optional]


## kuatercraft#0062 socials

* kuatercraft#0062
* [Our website](https://kuatercraft.ga/)
* [Our DCbot](https://kuatercraftbot.tk/)
* [Discord](https://discord.gg/zQ3SQ4zzN5/)
