<?php

  include $_SERVER['DOCUMENT_ROOT']."/Scripts/php/deployQueryResultToHtmlDiv.php";
  include $_SERVER['DOCUMENT_ROOT']."/Scripts/php/cttQueryResultToHtmlTable.php";

  function activity($type, $status, $mysqli ,$pageHeading) { //status is completed/ongoing/undeoployed/all type is a/q/t
          $str = '';
          $successFlag = '';
          $queryString = ("SELECT
          dl.depId AS 'Id',
          dl.depType AS 'Type',
          c.classNumber AS 'Class',
          c.classId AS 'Class Id',
          s.sectionId AS 'SectionId',
          s.Sections AS 'Section',
          dl.schStartDate AS 'Open From',
          dl.schEndDate AS 'Open Till',
          dl.deploySuccess AS 'Deployed?',
          a.assessment_Id AS 'Assessment ID',
          a.assessment_Title AS 'Title',
          CONCAT('[',json_arrayagg(
        		json_object(
        			'questionID',qb.qId,
        			'question',qb.question,
        			'option1',qb.Option_1,
        			'option2',qb.Option_2,
        			'option3',qb.Option_3,
        			'option4',qb.Option_4,
        			'option5',qb.Option_5,
        			'option6',qb.Option_6
      		)
      		),']') as 'Questions'
          FROM
              deploymentlog as dl
          INNER JOIN assessments as a
          	ON a.assessment_Id = dl.assessmentId
          INNER JOIN assessment_questions as aq
              ON aq.assessment_Id = a.assessment_Id
          INNER JOIN questionbank as qb
          	ON qb.qId = aq.question_id
          INNER JOIN questiontype as qt
          	on dl.depType = qt.qtId
          INNER JOIN classes as c
          	on c.classId = dl.classId
          INNER JOIN sections as s
          	on s.sectionId = dl.sectionId
      	");
      if ($status == "ongoing") {
        $str = "WHERE dl.schStartDate < CURDATE() AND dl.schEndDate > CURDATE() AND dl.deploySuccess = 1 AND dl.depType = '$type'";
        $successFlag = 1;//need this separately for display
        $queryString = $queryString.$str ;
      }
      if ($status == "completed") {
        $str = "WHERE dl.schStartDate < CURDATE() AND dl.schEndDate < CURDATE() AND dl.deploySuccess = 1 AND dl.depType = '$type'";
        $successFlag = 1;//need this separately for display
        $queryString = $queryString.$str ;
      }
      if ($status == "undeployed") {
        $str = "WHERE dl.deploySuccess = 0 AND dl.depType = '$type'";
        $successFlag = 0;//need this separately for display
        $queryString = $queryString.$str ;
      }
      $queryString = $queryString."  GROUP BY dl.depId";
        if ($status == "all") {
          $queryString = ("SELECT
                a.assessment_Title AS 'Title',
                a.assessment_Id AS 'Assessment ID',
                dl.classId AS 'Class Id',
                c.classNumber AS 'Class',
            	json_arrayagg(
            		json_object(
            			'questionID',qb.qId,
            			'question',qb.question,
            			'option1',qb.Option_1,
            			'option2',qb.Option_2,
            			'option3',qb.Option_3,
            			'option4',qb.Option_4,
            			'option5',qb.Option_5,
            			'option6',qb.Option_6
            		)
            		) as 'Questions',
            	json_arrayagg(DISTINCT
            		json_object(
            			'classId', dl.classId,
                  'classNumber', c.classNumber,
                  'sectionId', dl.sectionId,
                  'sectionName', s.Sections,
                  'startDate', dl.schStartDate,
                  'endDate', dl.schEndDate,
                  'deploySuccess', dl.deploySuccess
            		)
            		) as 'Deployments'
            FROM
                questionbank AS qb
            INNER JOIN assessment_questions AS aq
            	on aq.question_id = qb.qId
            INNER JOIN assessments as a
            	on a.assessment_Id = aq.assessment_Id
            LEFT JOIN deploymentlog as dl
            	on dl.assessmentId = aq.assessment_Id
            LEFT JOIN classes as c
            	on c.classId = dl.classId
            LEFT JOIN sections as s
            	on s.sectionId = dl.sectionId
            GROUP BY a.assessment_Title;") ;
        }
      $query = $mysqli->query($queryString);
      // $query should be returned
      div($query, $type, $successFlag, $status, $pageHeading);
  }

  function teachers ($mysqli,$stuQuery) {

    $teacherQuery = $mysqli->query("SELECT DISTINCT
      U.userId AS 'T Id',
      U.firstName AS 'T First Name',
      U.middleName AS 'T Middle Name',
      U.lastName AS 'T Last Name',
      U.Email AS 'T External Email',
      U.systemEmail AS 'T Internal Email',
      U.phoneMobile AS 'T Mobile',
      U.visibility AS 'Current',json_arrayagg(DISTINCT json_object(
          'Class Id',CTT.classId,
          'Class Num', C.classNumber,
          'Sec Id', Sec.sectionId,
          'Sec Name', Sec.Sections,
          'Sub Id', Sub.subjectId,
          'Sub Name', Sub.Subject
        ) ) as 'CSSubjects',
        json_arrayagg(DISTINCT json_object(
            'SD C Id', CTT.classId,
            'SD Class Num', C.classNumber,
            'Stu Sec name', Sec.Sections,
            'SD sectionId', Sec.sectionId
          ) ) as 'CSections'
        FROM
          users AS U
            INNER JOIN classes_taught_by_teacher AS CTT
              on CTT.userId = U.userId
            INNER JOIN subjects AS Sub
              on Sub.subjectId = CTT.subjectId
            LEFT JOIN classes as C
              on C.classId= CTT.classId
            LEFT JOIN sections as Sec
              on Sec.sectionId= CTT.sectionId
        GROUP BY U.userId
              ORDER BY U.userId ASC");
        table ($mysqli, $teacherQuery,$stuQuery);

  }

  function students ($mysqli, $pageHeading) {
      $query = $mysqli->query("SELECT DISTINCT
          C.classId AS 'C Id',
          C.classNumber AS 'Class / Std',
            json_arrayagg(DISTINCT json_object(
              'SD C Id', SD.classId,
              'Stu Sec name', Sec.Sections,
              'SD sectionId', SD.sectionId
            ) ) as 'Sections',
            json_arrayagg(DISTINCT json_object(
              'Stu C Id', SD.classId,
              'Stu sectionId', SD.sectionId,
              'Stu Id', SD.userId,
              'Stu RN', SD.rollNumber,
              'S First Name', U.firstName,
              'S Middle Name', U.middleName,
              'S Last Name', U.lastName
            ) ) as 'Students',
            COUNT(SD.userId) AS 'Count'
          FROM
            classes as C
          INNER JOIN studentDetails AS SD
            ON SD.classId = C.classId
          LEFT JOIN sections AS Sec
            ON Sec.sectionId = SD.sectionId
          INNER JOIN users as U
            ON U.userId = SD.userId

          Group BY C.classId
        ");
            stuDiv($query,$pageHeading);
            return ($query->fetch_assoc());
  }

  function studentsForTeacher($mysqli) {
    	$stuQuery = $mysqli->query("SELECT
        SD.userId AS 'U Id',
    		SD.classId,
    		C.classNumber AS 'Class',
    		SD.sectionId,
    		S.Sections AS 'Section',
    		U.firstName AS 'F Name',
    		U.middleName AS 'M Name',
    		U.lastName AS 'L Name',
    		SD.rollNumber AS 'R No.'
    		FROM studentDetails AS SD
    		INNER JOIN classes AS C ON C.classId = SD.classId
    		INNER JOIN sections AS S ON S.sectionId = SD.sectionId
    		INNER JOIN users AS U ON U.userId = SD.userId
    		ORDER BY SD.classId ASC, SD.sectionId ASC
    		");
    		$q = ($stuQuery->fetch_assoc());
    teachers($mysqli,$stuQuery);
    		// teachers($mysqli,$stuQuery);

    }

  function classesTaughtByTeachers_bkp($mysqli) {
    $query = $mysqli->query("SELECT
      subjects.subjectId AS 'Sub Id',
      subjects.Subject AS 'Subject',
      classes.classNumber AS 'Class / Std',
      classes.classId AS 'C Id',
      sections.Sections AS 'Section',
      users.userId AS 'T Id',
      users.firstName AS 'F Name',
      users.middleName AS 'M Name',
      users.lastName AS 'L Name'
      FROM
        users,
        classes_taught_by_teacher,
        classes,
        sections,
        subjects
      WHERE
        users.userId = classes_taught_by_teacher.userId AND
        classes.classId = classes_taught_by_teacher.classId AND
        sections.sectionId = classes_taught_by_teacher.sectionId AND
        classes_taught_by_teacher.subjectId = subjects.subjectId
      ORDER BY
        subjects.Subject ASC,
        classes.classId ASC,
        sections.Sections ASC
        ");
    cttQueryResultToHtmlTable ( $query);
  }

  function classesTaughtByTeachers($mysqli) {
    $query = $mysqli->query("SELECT DISTINCT
      Sub.subjectId AS 'Sub Id',
      Sub.Subject AS'Sub Name',
      json_arrayagg(DISTINCT json_object(
        'T First Name', U.firstName,
        'T Middle Name', U.middleName,
        'T Last Name', U.lastName,
        'T Class Id',CTT.classId,
        'T Sec Name', Sec.Sections,
        'T Sub Id', Sub.subjectId
      ) ) as 'Teachers',
      json_arrayagg(DISTINCT json_object(
          'Cl Id',CTT.classId,
          'Cl Num', C.classNumber
        ) ) as 'Cls',
      json_arrayagg(DISTINCT json_object(
          'Class Id',CTT.classId,
          'Class Num', C.classNumber,
          'Sec Id', Sec.sectionId,
          'Sec Name', Sec.Sections
        ) ) as 'CSections'
        FROM
          subjects AS Sub
            INNER JOIN classes_taught_by_teacher AS CTT
              on CTT.subjectId = Sub.subjectId
            INNER JOIN users AS U
              on U.userId = CTT.userId
            LEFT JOIN classes as C
              on C.classId= CTT.classId
            LEFT JOIN sections as Sec
              on Sec.sectionId= CTT.sectionId
        GROUP BY Sub.subjectId
              ORDER BY Sub.subjectId ASC
        ");
    cttQueryResultToHtmlTable ( $query);
  }



?>
