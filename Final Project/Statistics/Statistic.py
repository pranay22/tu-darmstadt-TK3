import mysql.connector
import datetime

'''
Checks if a seat is occupied by calculating its probability from the last 7 days (or 10080 entries).
Fetches all entries for the seat_id with its corresponding room_id and the occupy value.
Afterwards all entries when a seat is occupied is counted and divided through the amount of entries
If result is > 0.5, then seat is likely to be occupied, otherwise it is free. Returns free/occupied as result
'''
def check_occupied(req_room_id, req_seat_id):

    count = 0
    try:
        # connects to mysql database
        now_hour = datetime.datetime.now().hour
        
        # checks a few hours before actual time if in the previous entries a seat was taken and calculates its probability
        range = []
        if(now_hour == 0):
            range = [22,21,0]
        elif(now_hour == 1):
            range = [23,22,1]
        elif(now_hour == 2):
            range = [23,0,1,2]
        elif(now_hour == 23):
            range = [21,22,23]
        elif(now_hour == 22):
            range = [20,21,22] 
        elif(now_hour == 21):
            range = [19,20,21] 
        else:
            range = [now_hour-2,now_hour-1,now_hour] 
            
        
        cnx = mysql.connector.connect(user='tk3', password='tk3', host='127.0.0.1', database='tk3_final_project')
        cursor = cnx.cursor()
        
        # prepares, executes the query and fetches results  
        query = ("SELECT times, occupied FROM history WHERE seat_id="+str(req_seat_id)+" AND room_id="+str(req_room_id)+" ORDER by room_id DESC;")
        #query = ("SELECT times, occupied FROM history WHERE seat_id="+req_seat_id+" AND room_id="+req_room_id+" ORDER by room_id DESC;")
        cursor.execute(query)
        res = cursor.fetchall()


        # calculates probability for a seat    
        overall_pred = 0.0
        for row in res:
            if(row[0].hour in range):
                overall_pred = overall_pred + row[1]
                count = count+1
            
        #print(overall_pred, count)
        if(count > 0):
            overall_pred = overall_pred/count
    
        # returns decision
        #print(overall_pred)
        if(overall_pred > 0.5):
            #return "occupied"
            print("occupied")
        else:
            #return "free"
            print("free")
			
    except mysql.connector.Error as err:
        print(err)
        
        
  
   
#for i in range(10):
#    print("Seat "+str(check_occupied(1 , i+1)))
