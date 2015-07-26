import mysql.connector
import random

count = 0
started = 0
temp = 0.0


'''
Change room and seats if necessary:
    room = 1   --> seats = 100
    room = 2   --> seats = 50
    room = 3   --> seats = 40
'''
room = 3
seats = 40

try:
    cnx = mysql.connector.connect(user='root', password='root', host='127.0.0.1', database='test')
    cursor = cnx.cursor()
    for seat in range(1,seats+1):
        print(seat)
        for day in range(1,8):
            #print(count_start, count_end)
            for x in range(24):
                for y in range(60):    
                    query = "INSERT INTO history (seat_id, occupied, room_id, times) VALUES (%s, %s, %s, %s);"
                    
                    if(count==0):
                        if(x<7):
                            temp = random.uniform(0.0,1.0)+0.1
                        elif(x>=8 and x<=12):
                            temp = random.uniform(0.0,1.0)+0.45
                        elif((x>12 and x<=14) or x==7):
                            temp = random.uniform(0.0,1.0)+0.3
                        elif(x>14 and x<=18):
                            temp = random.uniform(0.0,1.0)+0.5
                        elif(x>18 and x<=20):
                            temp = random.uniform(0.0,1.0)+0.3
                        else:
                            temp = random.uniform(0.0,1.0)+0.2
                        
                        count= random.randint(1,60)
                        
                    if(temp>=1.0 ):    
                        values = (seat,1,room,"2015-07-"+str(day)+" "+str(x)+":"+str(y)+":00")
                    else:
                        values = (seat,0,room,"2015-07-"+str(day)+" "+str(x)+":"+str(y)+":00")
                    #print(query, values)
                    cursor.execute(query, values)
                    cnx.commit()
                    count = count-1
except mysql.connector.Error as err:
    print(err) 
finally:
    cursor.close()
    cnx.close()
    
        
        
     
                 
                
                