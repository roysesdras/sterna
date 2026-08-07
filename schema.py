import mysql.connector

try:
    conn = mysql.connector.connect(
        host="db",
        user="root",
        password="SoftiP24",
        database="africa_db"
    )
    cursor = conn.cursor()
    cursor.execute("SHOW TABLES")
    tables = cursor.fetchall()
    for table in tables:
        print(f"Table: {table[0]}")
        cursor.execute(f"DESCRIBE {table[0]}")
        cols = cursor.fetchall()
        for col in cols:
            print(f"  - {col[0]} ({col[1]})")
except Exception as e:
    print(e)
