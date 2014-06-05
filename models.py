from django.db import models
from django.contrib.auth.models import User

# Create your models here.


class SchoolInfo(models.Model):
    
    user = models.OneToOneField(User)
    name = models.CharField(max_length=30)
    currCap = models.IntegerField('Current Capital')

class EventInfo(models.Model):

    EVENTS = (
	('Quiz', 'Quizzing'),
	('Design', 'Design'),
	('Robot', 'Robotics'),
	('Prog', 'Programming'),
	('Photo', 'Photography'),
#	('SurEven', 'Surprise Event'),
)

    MEMBERS = (
	(1, '1'),
	(2, '2'),
	(3, '3'),
)

    name = models.CharField('Name', choices = EVENTS)
    school = models.ForeignKey(SchoolInfo)
    nOfMem = models.IntegerField('Number of members', choices = NUMBERS)

    for mem in range(nOfMem):
	mem = models.CharField('Name of member', max_length = 15)
	memList += mem

class ProductInfo(models.Model):
    
    school = models.ForeignKey(SchoolInfo)
    name = models.CharField('Name of product', max_length = 20)
    descr = models.TextField('Description', max_length = 100)
    upForAcq = models.BooleanField('Up for acquisition', default = False)

