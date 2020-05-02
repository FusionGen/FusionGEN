<?php

interface Emulator
{
    /**
     * Returns all of the current emulators columns provided a table
     *
     * @param string $table
     *
     * @return array
     */
    public function getAllColumns(string $table): array;

    /**
     * Returns the column name provided the table name and the matching column name
     *
     * @param string $table
     * @param string $name
     *
     * @return string
     */
    public function getColumn(string $table, string $name): string;

    /**
     * Returns a query provided a query name
     *
     * @param string $name
     *
     * @return string
     */
    public function getQuery(string $name): string;

    /**
     * Returns the matching table name for the emulator
     *
     * @param string $name
     *
     * @return string
     */
    public function getTable($name): string;

    /**
     * Returns all of the expasions
     * TODO: Add this to a helper, this is being repeated in every emulator class
     *
     * @return array|bool
     */
    public function getExpansions();

    /**
     * Returns the name of the expasion provided an $id
     * TODO: Add into a helper aswell
     *
     * @param int $id
     *
     * @return string|bool
     */
    public function getExpansionName(int $id);

    /**
     * Returns the expansion's id provided a name
     * TODO: Add into a helper aswell
     *
     * @param string $name
     *
     * @return int|bool
     */
    public function getExpansionId(string $name);

    /**
     * Sends a console command
     *
     * @param string $command
     *
     * @return void
     */
    public function send(string $command);

    /**
     * Alias of send
     *
     * @param string $command
     *
     * @return void
     */
    public function sendCommand(string $command);

    /**
     * Sends items to a given character
     *
     * @param string $character
     * @param string $subject
     * @param string $body
     * @param array $items
     *
     * @return void
     */
    public function sendItems(string $character, string $subject, string $body, array $items);

    /**
     * Sends mail to a given character
     *
     * @param string $character
     * @param string $subject
     * @param string $body
     *
     * @return void
     */
    public function sendMail(string $character, string $subject, string $body);

    /**
     * Checks wether the current emulator has console
     *
     * @return bool
     */
    public function hasConsole(): bool;

    /**
     * Checks wether the current emulator has character stats
     *
     * @return bool
     */
    public function hasStats(): bool;

    /**
     * Encrypts the password
     *
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    public function encrypt($username, $password);

    public function __construct($config);
}
