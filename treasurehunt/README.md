# Treasure Hunt

## Description

Create a treasure hunt game for a determined number of players.

Treasure Hunt is a game where a player is given only one clue to find the next clue until all of the __tokens__ are gathered. 

Clues must lead to the location of another clue.

Each clue has a token, when all the clues are gathered, the tokens need to be sorted in order to be find the hidden word or password to find the __treasure__.

## Usage

On your terminal do

`php treasurehunt.php`

This command will prompt you to fill each of the clues for the given token defined in the `$treasure` attribute.

After the clues are filled, they will be sorted for the number of players specified in `$players` and put into a `treasurehunt.csv` file ready to be imported into a spreadsheet and print the game.

The number of clues is determined by the `$segment` number, this is the length of the game. By default, the segment divides the token by 1, but the token can be segmented by 2 or more to reduce the number of clues.

## Extras

The game is designed so the players won't meet at the same time in the same location

The resulting CSV groups the clues by location, so when you distribute the clues, you only visit each location only once for all the players

Each row of the game has 

- `clue/total_clues` Clue description
- Token
- Corresponding player 