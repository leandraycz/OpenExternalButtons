#include <wiringPi.h>
#include <stdio.h>
#include <stdbool.h>
#include <stdlib.h>
#include <mariadb/mysql.h>
#include <string.h>
#include <stdlib.h>

int main(int argc, char *argv[])
{
	if (wiringPiSetupGpio() == -1) { // Nastavení GPIO podle BCM číslování
        printf("Chyba při inicializaci WiringPi!\n");
        return 1;
    	}

	if(strcmp(argv[1], "-pp") == 0) //Stisknutí napájecího tlačítka
	{
		MYSQL *conn = mysql_init(NULL);
                if (mysql_real_connect(conn, "localhost", "root", "14901490", "openexternalbuttons", 3306, NULL, 0) == NULL)
                {
                        fprintf(stderr, "Chyba připojení: %s\n", mysql_error(conn));
                        mysql_close(conn);
                        return 1;
                }
                char sql[] = "SELECT powerpin FROM computers WHERE name = '";
                strcat(sql, argv[2]);
                strcat(sql, "'");
                if (mysql_query(conn, sql))
                {
                        fprintf(stderr, "Chyba dotazu: %s\n", mysql_error(conn));
                }
                else
                {
                        MYSQL_RES *res = mysql_store_result(conn);
                        if (res)
                        {
                                MYSQL_ROW row;
                                while ((row = mysql_fetch_row(res)))
                                {
					pinMode(atoi(row[0]), OUTPUT);
					digitalWrite(atoi(row[0]), LOW);
					delay(100);
					digitalWrite(atoi(row[0]), HIGH);
                                }
                                mysql_free_result(res);
                        }
                }
                mysql_close(conn);

	}
	else if(strcmp(argv[1], "-hp") == 0) //Podržení napájecího tlačítka
	{
		MYSQL *conn = mysql_init(NULL);
        	if (mysql_real_connect(conn, "localhost", "root", "14901490", "openexternalbuttons", 3306, NULL, 0) == NULL)
        	{
                	fprintf(stderr, "Chyba připojení: %s\n", mysql_error(conn));
                	mysql_close(conn);
                	return 1;
        	}
		char sql[] = "SELECT powerpin FROM computers WHERE name = '";
		strcat(sql, argv[2]);
		strcat(sql, "'");
        	if (mysql_query(conn, sql))
        	{
                	fprintf(stderr, "Chyba dotazu: %s\n", mysql_error(conn));
        	}
        	else
        	{
                	MYSQL_RES *res = mysql_store_result(conn);
                	if (res)
                	{
                        	MYSQL_ROW row;
                        	while ((row = mysql_fetch_row(res)))
                       		{
                                	pinMode(atoi(row[0]), OUTPUT);
                                        digitalWrite(atoi(row[0]), LOW);
                                        delay(10000);
                                        digitalWrite(atoi(row[0]), HIGH);
                        	}
                		mysql_free_result(res);
                	}
        	}
        	mysql_close(conn);

	}
	else if(strcmp(argv[1], "-pr") == 0) //Stisknutí resetovacího tlačítka
	{
		MYSQL *conn = mysql_init(NULL);
                if (mysql_real_connect(conn, "localhost", "root", "14901490", "openexternalbuttons", 3306, NULL, 0) == NULL)
                {
                        fprintf(stderr, "Chyba připojení: %s\n", mysql_error(conn));
                        mysql_close(conn);
                        return 1;
                }
                char sql[] = "SELECT resetpin FROM computers WHERE name = '";
                strcat(sql, argv[2]);
                strcat(sql, "'");
                if (mysql_query(conn, sql))
                {
                        fprintf(stderr, "Chyba dotazu: %s\n", mysql_error(conn));
                }
                else
                {
                        MYSQL_RES *res = mysql_store_result(conn);
                        if (res)
                        {
                                MYSQL_ROW row;
                                while ((row = mysql_fetch_row(res)))
                                {
                                        pinMode(atoi(row[0]), OUTPUT);
                                        digitalWrite(atoi(row[0]), LOW);
                                        delay(100);
                                        digitalWrite(atoi(row[0]), HIGH);
                                }
                                mysql_free_result(res);
                        }
                }
                mysql_close(conn);

	}
	else
	{
		printf("Neznámý příkaz\n");
	}

	return 0;
}
