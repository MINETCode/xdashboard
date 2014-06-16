from django.db import models
from django.contrib.auth.models import User


class School(models.Model):
    
    user = models.OneToOneField(User)
    name = models.CharField('Name of school', max_length=30)
    currCap = models.IntegerField('Current Capital')

    def __unicode__(self):
	return self.name


class Event(models.Model):

    EVENTS = (
	('Quiz', 'Quizzing'),
	('Design', 'Design'),
	('Robot', 'Robotics'),
	('Prog', 'Programming'),
	('Photo', 'Photography'),
#	('SurEven', 'Surprise Event'),
)

    memDict = {
	'Quiz': 3,
	'Design': 2,
	'Robot': 2,
	'Prog': 2,
	'Photo': 1,
#	'SurEven': 2,	
}

    name = models.CharField('Name of event', max_length = 20, choices = EVENTS)

    def __unicode__(self):
	return self.name.verbose_name


class EventTeam(models.Model):

    school = models.ForeignKey('School')
    event = models.ForeignKey('Event')
#    mem1 = models.CharField('Member 1', max_length = 20)
#    mem2 = models.CharField('Member 2', max_length = 20, blank=True)
#    mem3 = models.CharField('Member 3', max_length = 20, blank=True)

    def __unicode__(self):
	str = self.event + ': ' + self.school.name
	return str


class Member(models.Model):
    
    name = models.CharField('Name of member', max_length = 20)
    events = models.ManyToManyField('EventTeam')

    def __unicode(self):
	return self.name
    

class Product(models.Model):
    
    school = models.ForeignKey('School')
    name = models.CharField('Name of product', max_length = 20)
    descr = models.TextField('Description', max_length = 100)
    upForAcq = models.BooleanField('Up for acquisition', default = False)

    def __unicode__(self):
	return self.name


class Genius(models.Model):

    school = models.ForeignKey('School')
    name = models.CharField('Name', max_length = 20)

    class Meta:
	verbose_name_plural = 'Genii'

    def __unicode__(self):
	return self.name

def getEventList():

    EVENTS = (
	('Quiz', 'Quizzing'),
	('Design', 'Design'),
	('Robot', 'Robotics'),
	('Prog', 'Programming'),
	('Photo', 'Photography'),
#	('SurEven', 'Surprise Event'),
)

    return EVENTS
