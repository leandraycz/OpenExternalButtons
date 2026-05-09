#include <stdio.h>
#include <stdbool.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

#include <wiringPi.h>
#include <mariadb/mysql.h>

//Metoda pro čtení souboru
char *read_file(const char *filename)
{
    FILE *f = fopen(filename, "rb");
    if (!f) return NULL;
    fseek(f, 0, SEEK_END);
    long size = ftell(f);
    rewind(f);
    char *buffer = malloc(size + 1);
    if (!buffer) {
        fclose(f);
        return NULL;
    }
    fread(buffer, 1, size, f);
    buffer[size] = '\0';
    fclose(f);
    return buffer;
}

//Metoda pro odstranění nový řádků
void remove_spaces_newlines(char *s)
{
    char *src = s, *dst = s;

    while (*src) {
        if (*src != ' ' && *src != '\n' && *src != '\t' && *src != '\r') {
            *dst++ = *src;
        }
        src++;
    }
    *dst = '\0';
}


int main(int argc, char *argv[])
{
	//Proměnná s heslem k databázi
	char database_password[256];

	//Nastaví GPIO podle BCM číslování
	if(wiringPiSetupGpio() == -1)
	{
		printf("Chyba při initializaci knihovny WiringPi");
		return 1;
	}

	//Získá heslo k databázi a zapíše jej do proměnné
	if(access("/etc/OEB/dbpassword.txt", F_OK) == 0)
	{
		strcpy(database_password, read_file("/etc/OEB/dbpassword.txt"));
		remove_spaces_newlines(database_password);

		if(strcmp(argv[1], "--powerpress") == 0)
		{
			MYSQL *conn = mysql_init(NULL);
			if(mysql_real_connect(conn, "localhost", "root", database_password, "openexternalbuttons", 3306, NULL, 0) == NULL)
			{
				fprintf(stderr, "Chyba připojení k databázi: %s\n", mysql_error(conn));
				mysql_close(conn);
				return 1;
			}
			char sql[] = "SELECT powerpin FROM computers WHERE name = '";
                	strcat(sql, argv[2]);
                	strcat(sql, "'");
			if(mysql_query(conn, sql))
			{
				fprintf(stderr, "Chyba dotazu: %s\n", mysql_error(conn));
			}
			else
			{
				MYSQL_RES *res = mysql_store_result(conn);
				if(res)
				{
					MYSQL_ROW row;
					while((row = mysql_fetch_row(res)))
					{
						int pin = atoi(row[0]);
						pinMode(pin, OUTPUT);
						digitalWrite(pin, LOW);
						delay(100);
						digitalWrite(pin, HIGH);
					}
					mysql_free_result(res);
				}
			}
			mysql_close(conn);
		}
		else if(strcmp(argv[1], "--resetpress") == 0)
		{
			MYSQL *conn = mysql_init(NULL);
                        if(mysql_real_connect(conn, "localhost", "root", database_password, "openexternalbuttons", 3306, NULL, 0) == NULL)
                        {
                                fprintf(stderr, "Chyba připojení k databázi: %s\n", mysql_error(conn));
                                mysql_close(conn);
                                return 1;
                        }
			char sql[] = "SELECT resetpin FROM computers WHERE name = '";
                        strcat(sql, argv[2]);
                        strcat(sql, "'");
			 if(mysql_query(conn, sql))
                        {
                                fprintf(stderr, "Chyba dotazu: %s\n", mysql_error(conn));
                        }
                        else
			{
				MYSQL_RES *res = mysql_store_result(conn);
                                if(res)
                                {
                                        MYSQL_ROW row;
                                        while((row = mysql_fetch_row(res)))
                                        {
                                                int pin = atoi(row[0]);
                                                pinMode(pin, OUTPUT);
                                                digitalWrite(pin, LOW);
                                                delay(100);
                                                digitalWrite(pin, HIGH);
                                        }
                                        mysql_free_result(res);
                                }
			}
			mysql_close(conn);
		}
		else if(strcmp(argv[1], "--powerhold") == 0)
		{
			MYSQL *conn = mysql_init(NULL);
                        if(mysql_real_connect(conn, "localhost", "root", database_password, "openexternalbuttons", 3306, NULL, 0) == NULL)
                        {
                                fprintf(stderr, "Chyba připojení k databázi: %s\n", mysql_error(conn));
                                mysql_close(conn);
                                return 1;
                        }
                        char sql[] = "SELECT powerpin FROM computers WHERE name = '";
                        strcat(sql, argv[2]);
                        strcat(sql, "'");
                        if(mysql_query(conn, sql))
                        {
                                fprintf(stderr, "Chyba dotazu: %s\n", mysql_error(conn));
                        }
                        else
                        {
                                MYSQL_RES *res = mysql_store_result(conn);
                                if(res)
                                {
                                        MYSQL_ROW row;
                                        while((row = mysql_fetch_row(res)))
                                        {
                                                int pin = atoi(row[0]);
                                                pinMode(pin, OUTPUT);
                                                digitalWrite(pin, LOW);
                                                delay(10000);
                                                digitalWrite(pin, HIGH);
                                        }
                                        mysql_free_result(res);
                                }
                        }
                        mysql_close(conn);

		}
		else if(strcmp(argv[1], "--ver") == 0)
		{
			printf("1.0.0.2");
		}
	}
	else
	{
		printf("Nelze přistoupit k souboru s heslem k databázi. Soubor pravděpodobně neexistuje. Zastavuji program! \n");
		return 1;
	}

}

