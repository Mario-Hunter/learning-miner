# -*- coding: utf-8 -*-
"""
Created on Thu May 18 01:26:37 2017

@author: Mario
"""
import mysql.connector
import numpy as np
from scipy.stats import pearsonr
STANDARD_CORR_VAL = 0.5

def getReviews(item,overlap):
    reviews=[]
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    for reviewer in overlap:
        query = "SELECT ranks.rank from ranks where course_id="+str(item)+" and user_id ="+ str(reviewer)
        cursor.execute(query)
        fetched = [coloumn[0] for coloumn in cursor.fetchall()]
        for x in fetched:
            reviews.append(x)
    return reviews

def getReviewers(item):
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    query = ("SELECT ranks.user_id FROM ranks where course_id="+str(item))
    cursor.execute(query)
    return [coloumn[0] for coloumn in cursor.fetchall()]

def get_intersected_reviewers(item1, item2):
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    query = ("SELECT user_id FROM learning_miner.ranks where course_id ="+str(item1)+" AND EXISTS( " +"SELECT user_id From learning_miner.ranks " +"where course_id = "+str(item2)+" )")
    cursor.execute(query)
    return [coloumn[0] for coloumn in cursor.fetchall()]

def correlation(item1,item2):
    #item1_reviewers = getReviewers(item1)
    #item2_reviewers = getReviewers(item2)
    
    #overlap = set(item1_reviewers).intersection(item2_reviewers)
    overlap = get_intersected_reviewers(item1, item2)
    if len(overlap) == 0:
        return 0
    else:
        item1_reviews = getReviews(item1,overlap)
        item2_reviews = getReviews(item2,overlap)
        
        corr = pearsonr(item1_reviews,item2_reviews)
        return corr

def getGoodReviewrs(item):
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    query = ("SELECT ranks.user_id FROM ranks where course_id="+str(item)+" and rank >3")
    cursor.execute(query)
    return [coloumn[0] for coloumn in cursor.fetchall()]
 
def store_recommend(users,item,ref):
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    for user in users:
        print "saving .. "+ str(user) + " and " + str(item)
        query = "Insert into item_item_rec (user_id,course_id,reference_course_id) VALUES ("+str(user)+","+str(item)+","+str(ref)+")"
        cursor.execute(query)
        
        
def recommend(item1,item2):
    corr = correlation(item1,item2)
    print "corr of "+str(item1)+" and " + str(item2) + " is " +str(corr)
    if (corr != "nan" and corr > STANDARD_CORR_VAL ):
        store_recommend(getGoodReviewrs(item1),item2,item1)
        store_recommend(getGoodReviewrs(item2),item1,item2)
        

def item_item():
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    query = ("SELECT courses.id FROM courses")
    cursor.execute(query)
    ids = [coloumn[0] for coloumn in cursor.fetchall() ]
    print ids
    for i in range (0,len(ids)):
        for j in range(i+1,len(ids)):
            recommend(ids[i],ids[j])
            

def main():
    cnx = mysql.connector.connect(user='root', password='',
                                  host='127.0.0.1',
                                  database='learning_miner')
    cursor =cnx.cursor()
    query = ("SELECT course_tag.course_id FROM course_tag ")
    
    cursor.execute(query)
    courses_ids = [coloumn[0] for coloumn in cursor.fetchall()]
    features = []
    max_length = 0
    for course_id in courses_ids:
        query ="SELECT tags.`id` FROM courses,tags,course_tag where courses.id=course_tag.course_id and tags.id=course_tag.tag_id and courses.id = "+str(course_id)
        cursor.execute(query)
        tags = [coloumn[0] for coloumn in cursor.fetchall() ]
        if (len(tags) != 0 and tags not in features):
            print tags
            features.append(tags)
            if(len(tags) > max_length ):
                max_length =len(tags)
                
    #for feature in features:
     #   for i in range(len(feature),max_length):
     #       feature.append(0)
            
        
    print features
    
    x =np.array(features)
    from sklearn.cluster import KMeans
    kmeans = KMeans(n_clusters = 2,random_state =0 ).fit(x)
    print kmeans.labels_
    print kmeans.predict([4,12,13,0,0])       
        
    
print item_item()