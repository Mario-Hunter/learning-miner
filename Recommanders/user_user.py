# -*- coding: utf-8 -*-
"""
Created on Thu May 18 15:46:09 2017

@author: Mario
"""
import mysql.connector

def user_similiarity(user1,user2):
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    query ="SELECT course_id,rank,user_id FROM learning_miner.ranks as rk1 where user_id ="+str(user1)+"  AND EXISTS(  SELECT rank,course_id  From learning_miner.ranks as rk2 where user_id = "+str(user2)+" and rk1.course_id = rk2.course_id ) Order BY course_id"
    
    cursor.execute(query)
                                                                                       
    similiar_ranks_user1 =  [coloumn[1] for coloumn in cursor.fetchall()]
    print similiar_ranks_user1
    query = ("SELECT COUNT(rank) FROM learning_miner.ranks where user_id  ="+ str(user1))
    cursor.execute(query)
    user1_ranks_count = [coloumn[0] for coloumn in cursor.fetchall()]
    
    if (len(similiar_ranks_user1) == 0  or user1_ranks_count[0] / len(similiar_ranks_user1) < 0.7):
        return 5
    query ="SELECT course_id,rank,user_id FROM learning_miner.ranks as rk1 where user_id ="+str(user2)+"  AND EXISTS(  SELECT rank,course_id  From learning_miner.ranks as rk2 where user_id = "+str(user1)+" and rk1.course_id = rk2.course_id ) Order BY course_id"
    
    cursor.execute(query)
                                                                                       
    similiar_ranks_user2 =  [coloumn[1] for coloumn in cursor.fetchall()]
    
    distance = sum([abs(score1 -score2) for score1 ,score2 in zip(similiar_ranks_user1, similiar_ranks_user2)])
    print distance
    distance = distance / float(len(similiar_ranks_user1))
    return distance

def getFans(item):
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    query = "SELECT ranks.user_id,ranks.rank,courses.`name`,courses.rank FROM learning_miner.ranks join courses on courses.id = ranks.course_id where ranks.rank >= courses.rank and course_id = "+str(item)    
    cursor.execute(query)
                                                                                       
    return [coloumn[0] for coloumn in cursor.fetchall()]

def  user_fan_similiarity(user,item):
    similiarity_vals_list = []
    fans = getFans(item)
    print "fans of " +str(item)+" are "
    print fans
    for fan in fans:
        similiarity_vals_list.append(user_similiarity(user,fan))
    print similiarity_vals_list
    if(len(similiarity_vals_list) == 0 ):
        return 5
    return  sum(similiarity_vals_list)/float(len(similiarity_vals_list))

def store_recommend(user,item):
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    
    print "saving .. "+ str(user) + " and " + str(item)
    query = "Insert into user_user_rec (user_id,course_id) VALUES ("+str(user)+","+str(item)+")"
    cursor.execute(query)
        
        
def recommend(user,item):
    fan_distance = user_fan_similiarity(user,item)
    print "fan_distance of "+str(user)+" and " + str(item) + " is " +str(fan_distance)
    if (fan_distance < 2 ):
        store_recommend(user,item)
        
        
        
def user_user():
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    query = ("SELECT users.id FROM users")
    cursor.execute(query)
    ids = [coloumn[0] for coloumn in cursor.fetchall() ]
    query = "SELECT courses.id FROM courses"
    cursor.execute(query)
    courses = [ coloumn[0] for coloumn in cursor.fetchall()]
    print ids
    for user in ids:
        for item in courses:
            recommend(user,item)
    
user_user()