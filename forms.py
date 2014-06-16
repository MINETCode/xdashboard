from django import forms
from django.forms.formsets import BaseFormSet

from xdashboard.models import School, Event, EventTeam, Product

#class SchoolForm(forms.ModelForm):
#    class Meta:
#	model = School
#	fields = ('name')


class EventTeamForm(forms.Form):

    event = forms.BooleanField()
    mem1 = forms.CharField(label="Member 1", max_length = 20)
    mem2 = forms.CharField(label="Member 2", max_length = 20, required = False)

    if event.label == 'Quizzing':
	mem3 = forms.CharField(label="Member 3", max_length = 20, required = False)
		
class BaseEventTeamFormSet(BaseFormSet):

    def __init__(self, *args, **kwargs):
	super(BaseEventTeamFormSet, self).__init__(*args, **kwargs)
	
	for i in range(0, len(Event.EVENTS)):
	    self[i].fields['event'].label = Event.EVENTS[i][1]


class ProductForm(forms.ModelForm):
    class Meta:
	model = Product
	fields = ('name', 'descr', 'upForAcq')
