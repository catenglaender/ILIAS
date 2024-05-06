# Individual Assessment Privacy

Disclaimer: This documentation does not warrant completeness or correctness. Please report any missing or wrong information using the [ILIAS issue tracker](https://mantis.ilias.de) or contribute a fix via [Pull Request](docs/development/contributing.md#pull-request-to-the-repositories).


### General Information

An Individual Assessment may be part of another object's Learning Progress.

A managing user can add users from other objects as Participants to the Individual Assessment, e.g. from entire Courses or Groups.

Even after a person's membership to the original object has been removed, it may be obvious where the Users came from. For example, a Course might include an Individual Assessment and have most of the same Users in both. If a Participant is only part of the Individual Assessment, it's likely they also used to be a member of that Course at some point.

Please consult the respective privacy.mds: (Links)

## Data being stored

- **Participants**: Importing users to the Individual Assessment references their User object. Their full name is stored alongside a grading.
- **Examiner**: The User who grades another User is referenced by ID. If another user later amends the record, their User ID gets stored as well.
- **Changed after finalization**: If the record was edited after finalization, the date and time of this change will be stored.
- **Location, time and date of an exam**: The Examiner is asked about when and where an exam took place.
- **Grading**: The Examiner selects whether the Participant Completed or Failed the assessment. Grading might influence the overall Learning Progress of another object.
- **Contact Information**: In  the Info Settings sub-tab, contact information can be entered. This may include a person's Name, Responsibility, Phone, Email and Consultation Hours.
- The Individual Assessment component employs the following services, please consult the respective privacy.mds: [Metadata](../../Services/MetaData/Privacy.md), [AccessControl](../../Services/AccessControl/PRIVACY.md)


## Data being presented
- **Users**: The User input field in the toolbar of the Participants tab and the Add Member view can show user search results (last and first name, login name of a user). Please consult the respective privacy.md of the Search component: (link)
- **Courses & Groups**: Furthermore, the Add Member view can search for Courses and Groups. Please consult the respective privacy.md of the Search component: (link)
- **Participants**: The name of participants is presented in the Participants tab and the Editing View of the Participant's Record.
- **Examiner**: The name of the Examiner is shown in the Participants tab and the Editing View of the Participant Record. If the record is edited after finalizing it, the name of that Examiner is shown as well.
- **Changed after finalization**: If the record was edited after finalization, the date and time of this change will be shown.
- **Location, time and date of an exam** is shown in the Participants tab to managing users.
- **Grading**: is shown in the Participants tab, the Editing View of the Participant's Record and to the individual Participant within the Info Tab.
- **Contact Information**: The Info tab shows the manually entered contact information.

## Data being deleted 
- When deleting a single Participant record before finalizing it, the following personal data stored so far will be deleted:
  - reference to user ID for Participant
  - copy of the Participant's first, last, login name
  - Location, time and date of an exam
  - Grading
- After finalizing, Participant Records cannot be deleted individually. The entire Individual Assessment object needs to be deleted to remove data.
- When deleting the entire Individual Assessment, all records will be deleted and the following personal data potentially stored with it:
  - reference to user ID for Participant, original Examiner, Examiner who last edited
  - time and date of the last change
  - copy of the Participant's first, last, login name
  - Location, time and date of an exam
  - Grading
  - manually provided, optional contact information

## Data being exported 
- Only the settings of the Individual Assessment and no Participant records are exported. Therefor the only sensitive data included at this point is:
  - manually provided, optional contact information

## Summary

| Data                                                           | Stored in DB | Shown to general user | Shown to managing user | Exported | deletes w/ record [^finaliz] | deletes w/ obj |
|----------------------------------------------------------------|--------------|-----------------------|------------------------|----------|------------------------------|----------------|
| Reference to Participant User (ID)                             | yes          | no                    | as name                | no       | yes                          | yes            |
| Reference to Examiner User (ID)                                | yes          | no                    | as name                | no       | n.a.                         | yes            |
| Reference to Examiner User (ID), time and date for last change | yes          | no                    | yes                    | no       | n.a.                         | yes            |
| Copy of user's first, last, user name                          | yes          | no                    | yes                    | no       | yes                          | yes            |
| Search result: Any User's first, last, user name               | no           | no                    | yes                    | no       | n.a.                         | n.a.           |
| Search result: Any Group or Course name                        | no           | no                    | yes                    | no       | n.a.                         | n.a.           |
| Location, time and date of exam                                | yes          | no                    | yes                    | no       | yes                          | yes            |
| Grading                                                        | yes          | to individual         | yes                    | no       | yes                          | yes            |
| manually provided, optional contact information                | yes          | yes                   | yes                    | yes      | no                           | yes            |

[^finaliz]: before finalization. After finalizing a record, it can only be amended. To delete a finalized record, the entire object must be deleted.