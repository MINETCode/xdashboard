from django.db import models
from django.contrib.auth.models import User


class School(models.Model):
    
    user = models.OneToOneField(User)
    name = models.CharField('Name of school', max_length=30)
    currCap = models.IntegerField('Current Capital')
    updates = models.TextField('Updates', max_length=1000)

    def __unicode__(self):
	return self.name


class Event(models.Model):

    EVENTS = (
	('Quiz', 'Quizzing'),
	('Design', 'Design'),
	('Robot', 'Robotics'),
	('Prog', 'Programming'),
	('Photo', 'Photography'),
	('Game', 'Gaming'),
	('GD', 'Group Discussion'),
)

    memDict = {
	'Quiz': 3,
	'Design': 2,
	'Robot': 2,
	'Prog': 2,
	'Photo': 1,
	'Game': 1,
	'GD': 1,
}

    name = models.CharField('Name of event', max_length = 20, choices = EVENTS)

    def __unicode__(self):
	return self.name


class EventTeam(models.Model):

    school = models.ForeignKey('School')
    event = models.ForeignKey('Event')

    def __unicode__(self):
	str = self.event.name + ': ' + self.school.name
	return str


class Member(models.Model):
    
    name = models.CharField('Name of member', max_length = 20)
    events = models.ManyToManyField('EventTeam')

    def __unicode__(self):
	return self.name
    

class Product(models.Model):
    
    school = models.ForeignKey('School')
    name = models.CharField('Name of product', max_length = 20)
    descr = models.TextField('Description', max_length = 100)
    cost = models.IntegerField('Cost')
    upForAcq = models.BooleanField('Up for acquisition', default = False)
    isAcq = models.BooleanField('Acquired', default = False)
    acqSchool = models.CharField('School', max_length = 30, blank = True, null = True)

    def __unicode__(self):
	str = self.name + ': ' + self.school.name
	return str

class Genius(models.Model):

    name = models.CharField('Name', max_length = 20)
    school = models.CharField('School', max_length = 30, blank = True, null = True)
    active = models.BooleanField('Active', default = False)

    class Meta:
	verbose_name_plural = 'Genii'

    def __unicode__(self):
	return self.name
