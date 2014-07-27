from django import forms
from django.forms.formsets import BaseFormSet

from xdashboard.models import School, Event, EventTeam, Product


class EventTeamForm(forms.Form):

    event = forms.BooleanField()
    mem1 = forms.CharField(label="Member 1", max_length = 20, required = True)
    mem2 = forms.CharField(label="Member 2", max_length = 20, required = False)
		
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

    def add_fields(self, form, index):
        super(BaseEventTeamFormSet, self).add_fields(form, index)
        form.fields["Member 3"] = forms.CharField()

    def __init__(self, *args, **kwargs):
	super(BaseEventTeamFormSet, self).__init__(*args, **kwargs)
	
	for i in range(0, len(Event.EVENTS)):
	    self[i].fields['event'].label = Event.EVENTS[i][1]


class ProductForm(forms.ModelForm):
    class Meta:
	model = Product
	fields = ('name', 'descr', 'upForAcq', 'cost')

class ProductAcqForm(forms.Form):
    acq = forms.BooleanField()
