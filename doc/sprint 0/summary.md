Arduino based plant maintanence system

An arduino powered device which measures the humidity of a flower plant and releases a valve to water it.

Project Objective: We are going to create an arduino based plant management system. It will automatically detect moisture levels in the soil and water the plants appropriately. It will also measure temperature, humidity, and make suggestions. It will keep track of data about the plants such as when it was watered, sunlight levels, age and allow users to input their own data too. We will be able to present the data back to the User, and make graphs to help visualize the data too. Also, it will have a software component where we can control remotely, for manual watering, graphs, tracking, (ex. how much water it got) 

Watering time depends on moisture levels and the data (i.e. how often it needs to be watered)
for example if data says every 6h, then water every 6h or when moist is low



Key Users:
- Beginners:
  Want to start learning about plants and growing their own
  
- Busy People (due to work, travel):
  Want to have plants within their household, but aren't always available to maintain them due to being busy
  
- Elderly people:
  Want to have plants within their household, but aren't always able to maintain them due to physical or mental limitations
  
- Lazy People:
  Want plants but don't want to care for them
  
- Handicapped People:
  Want plants but can't maintain them due to physical limitation
  
- Small Local Businesses (for decoration as an alternative to fake plants):
  Want to make their business look better and more environmentally friendly, so instead of using fake plants, they use real ones
  with this system to maintain them.
 
Principles: Minimal user interaction, plug and play

Materials:
valve
sunlight sensor
humidity sensor
moisture sensor
temperature sensor
arduino
wifi module
water tank
led to say if its on or not
water level sensor (maybe)
case
light source(maybe)

Technology we will be using:
sql
android(maybe)
php
html/css
C (for arduino)

Database:
Plantid, planttype
PlantType, humidity, temperature, moisture, sunlight, lowestMoistureAllowed

plantid, time, amountofwater

local: plantType, waterinterval

we need db to log info (so user can see progress or track) and also cuz we need that info to know when to water



Extra features: (after finishing main part):
app
scarecrow for birds or squirrels
consider weather?
no wifi, if no wifi then keep on recording data and watering and shit like a fitbit
local storage to track data and when it connects then upload it
measure nutrition, nitrogen, phosphorus, potassium
have a light bulb so that to increase the sunlight (since were aiming for indoors)



