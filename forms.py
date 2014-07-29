from django import forms
from django.forms.formsets import BaseFormSet

from xdashboard.models import School, Event, EventTeam, Product

"""
class RegisterForm(forms.Form):

    des = forms.BooleanField(label="Design")
    mem1 = forms.CharField(label="Member 1", max_length = 20, required = True)
    mem2 = forms.CharField(label="Member 2", max_length = 20, required = False)
    mem3 = forms.CharField(label="Member 3", max_length = 20, required = False)
    mem4 = forms.CharField(label="Member 4", max_length = 20, required = False)

    game = forms.BooleanField(label="Gaming")
    mem1 = forms.CharField(label="Member 1", max_length = 20, required = True)

    photo = forms.BooleanField(label="Photography")
    mem1 = forms.CharField(label="Member 1", max_length = 20, required = True)

    quiz = forms.BooleanField(label="Quizzing")
    mem1 = forms.CharField(label="Member 1", max_length = 20, required = True)
    mem2 = forms.CharField(label="Member 2", max_length = 20, required = False)
    mem3 = forms.CharField(label="Member 3", max_length = 20, required = False)

    robot = forms.BooleanField(label="Robotics")
    mem1 = forms.CharField(label="Member 1", max_length = 20, required = True)
    mem2 = forms.CharField(label="Member 2", max_length = 20, required = False)

    prog = forms.BooleanField("Programming")
    mem1 = forms.CharField(label="Member 1", max_length = 20, required = True)
    mem2 = forms.CharField(label="Member 2", max_length = 20, required = False)
"""

class EventTeamForm(forms.Form):

    event = forms.BooleanField()
    mem1 = forms.CharField(label="Member 1", max_length = 20, required = True)
    mem2 = forms.CharField(label="Member 2", max_length = 20, required = False)
    mem3 = forms.CharField(label="Member 2", max_length = 20, required = False)
    mem4 = forms.CharField(label="Member 2", max_length = 20, required = False)
		
class BaseEventTeamFormSet(BaseFormSet):

    def clean(self):
	if any(self.errors):
	    return
	for form in self.forms:
	    participating = form.cleaned_data.get('event')
	    mem1 = form.cleaned_data.get('mem1')
	    if participating == True:
		if mem1 == '':
		    raise forms.ValidationError("The 'Member 1' field is required.")
	    if participating == False:
		if mem1 != '':
		    raise forms.ValidationError("Please tick the required event.")		

    def __init__(self, *args, **kwargs):
	super(BaseEventTeamFormSet, self).__init__(*args, **kwargs)	
	for i in range(0, len(Event.EVENTS)):
	    self[i].fields['event'].label = Event.EVENTS[i][1]
	    singleMem = ['Gaming', 'Photography']
	    doubleMem = ['
	    if self[i].fields['event'].label == "Gaming":
		self[i].fields['mem2'].widget = forms.HiddenInput()

'''
    def add_fields(self, form, index):
        super(BaseEventTeamFormSet, self).add_fields(form, index)
	if form.fields['event'].label == 'Quizzing':
            form.fields['mem3'] = forms.CharField(label="Member 3", max_length = 20, required = False)
'''

class ProductForm(forms.ModelForm):
    class Meta:
	model = Product
	fields = ('name', 'descr', 'upForAcq', 'cost')

class ProductAcqForm(forms.Form):
    acq = forms.BooleanField(label='')
